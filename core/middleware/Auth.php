<?php

namespace Core\Middleware;

class Auth
{
    public static function guard()
    {
        if(isset($_SESSION['auth_user'])) {
            return true;
        }

        return redirect('/home');
    }

    /**
     * Returns true if there is an authorized user, otherwise false
     *
     * @return  boolean
     */
    public static function check()
    {
        if(isset($_SESSION['auth_user'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns the current authorized user
     *
     */
    public static function user()
    {

    }
}