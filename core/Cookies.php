<?php

namespace Core;

class Cookies 
{
    public static function setCookie($name, $value, $time = null)
    {
        return setcookie($name, $value, $time);
    }

    public static function destroyCookie($name)
    {
        return setcookie($name, "", time() - 3600);
    }
    
    public static function getCookie($name)
    {
        if(isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return false;
    }
}