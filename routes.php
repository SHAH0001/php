<?php

use Core\Router;

Router::get('/home', 'HomeController@index');
Router::get('/about', 'HomeController@about');

Router::get('/login', 'AuthController@showLoginForm');
Router::get('/register', 'AuthController@showRegisterForm');

Router::post('/login', 'AuthController@login');
Router::post('/register', 'AuthController@register');
Router::get('/logout', 'AuthController@logout');

Router::get('/admin/home', 'Admin\AdminHomeController@home');