<?php

namespace App\Http\Controllers;

use App\News;
use Core\View;
use Core\Cookies;
use RedBeanPHP\R;
use Core\Pagination;


class HomeController 
{
    public function index()
    {   
        $pagination = new Pagination('news');
    
        View::render('home', [
            'news' => $pagination->getData(), 
            'pagination' => $pagination
        ]);
    }

    public function about()
    {
        View::render('about');
    }
}