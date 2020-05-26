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
        $total = R::count('news');

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $perpage = 15;

        $pagination = new Pagination($page, $perpage, $total);

        $start  = $pagination->getStart();

        $news = R::findAll('news', "LIMIT $start, $perpage");
    
        View::render('home', [
            'news' => $news, 
            'pagination' => $pagination
        ]);
    }

    public function about()
    {
        View::render('about');
    }
}