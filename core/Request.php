<?php

namespace Core;

class Request
{
    /**
     * Get current uri.
     *
     * @return string
     */
    public static function uri()
    {
        $pattern = trim($_SERVER['REQUEST_URI'], '/');

        return $pattern == '' ? '/' : $pattern;
    }

    /**
     * Get request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}