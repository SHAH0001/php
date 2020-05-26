<?php

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/vendor/autoload.php';

RedBeanPHP\R::setup('mysql:host=localhost;dbname=php', 'root', '');

$router = new Core\Router();

try {
    $router->loadRoutes('routes.php')->start();
}
catch(Exception $error) {
    die($error->getMessage());
}
