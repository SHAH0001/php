<?php

namespace Core;

use Core\Request;
use Exception;

class Router
{
    protected static $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * method handles all requests
     *
     * @return  [type]  [return description]
     */
    public function start()
    {
        $uri = Request::uri();

        $uri = $this->reviewGet($uri);

        if(!array_key_exists($uri, static::$routes[Request::method()])) {
            throw new Exception("Route $uri does not exist.");
        }

        list($controller, $method) = explode('@', static::$routes[Request::method()][$uri]);

        try {
            $this->callMethod($controller, $method);
        }
        catch(Exception $error) {
            die($error->getMessage());
        }
    }

    protected function reviewGet($uri)
    {
        if(!stristr($uri, '?')) {
            return $uri;
        }

        list($queryString, $parameters) = explode('?', $uri);

        if(!$queryString) {
            return '/';
        }

        return $queryString;
    }

    /**
     * Creates an instance of the controller class and calls the desired method
     *
     * @param   string  $controller  [$controller description]
     * @param   string  $method      [$method description]
     *
     */
    protected function callMethod($controller, $method)
    {
        $controllerName = 'App\\Http\\Controllers\\' . $controller;
        
        if(!class_exists($controllerName)) {
            throw new Exception("Class $controller.php does not exist.");
        }

        $controller = new $controllerName;

        if(!method_exists($controller, $method)) {
            throw new Exception("Method <b>$method</b> does not exist in the controller <b>$controllerName</b>.");
        }   

        return $controller->$method();
    }

    /**
     * Loagind a file with routes
     *
     * @param   string  $routes 
     *
     * @return  $this
     */
    public function loadRoutes($routes)
    {
        require_once $routes;

        return $this;
    }

    /**
     * Add route to array with get.
     *
     * @param   string  $uri                   current uri
     * @param   string  $controllerWithMethod  controllerWithMethod
     *
     * @return  void                  
     */
    public static function get($uri, $controllerWithMethod) 
    {
        if($uri === '/') {
            static::$routes['GET'][$uri] = $controllerWithMethod;
        }
        else {
            static::$routes['GET'][trim($uri, '/')] = $controllerWithMethod;
        }
    }

    /**
     * Add route to array with post.
     *
     * @param   string  $uri                   current uri
     * @param   string  $controllerWithMethod  controllerWithMethod
     *
     * @return  void                  
     */
    public static function post($uri, $controllerWithMethod) 
    {
        if($uri === '/') {
            static::$routes['POST'][$uri] = $controllerWithMethod;
        }
        else {
            static::$routes['POST'][trim($uri, '/')] = $controllerWithMethod;
        }
    }

    /**
     * Return all routes. For development only.
     *
     * @return array
     */
    public static function getAllRoutes()
    {
        return self::$routes;
    }
}