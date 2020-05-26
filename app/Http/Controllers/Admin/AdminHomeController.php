<?php

namespace App\Http\Controllers\Admin;

use Core\View;
use Core\Middleware\Auth;

class AdminHomeController
{
    public function __construct()
    {
       Auth::guard();
    }
    
    public static function home()
    {
        return View::render('admin\\home');
    }
}