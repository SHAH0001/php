<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>News Blog</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="public/img/favicon.ico">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Sarabun:300,300i,400,400i,500,600,700,800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/css/vendor/bootstrap.min.css">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="public/css/vendor/font-awesome.min.css">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="public/css/plugins/slick.min.css">
    <!-- Odometer css -->
    <link rel="stylesheet" href="public/css/plugins/odometer.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="public/css/plugins/animate.css">
    <!-- main style css -->
    <link rel="stylesheet" href="public/css/style.css">

</head>

<body>

    <header class="header-area">
        <div class="main-header d-none d-lg-block">
            <div class="header-top theme-bg"  style="height: 50px;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <div class="login-register text-center">
                                <a href="/">News Blog</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-menu-wrapper sticky header-transparent">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <div class="brand-logo">
                                <a href="/">
                                    <img src="public/img/logo/logo.png" alt="brand logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="main-menu-inner">
                                <nav class="main-menu">
                                    <ul>
                                        <li class="active"><a href="/">Home</a></li>
                                        <li class="active"><a href="/about">About</a></li>

                                        <?php if(Core\Middleware\Auth::check()) : ?>
                                            <li class="active"><a href="/admin/home">Personal Room</a></li>
                                        <?php endif; ?>

                                        <?php if(!Core\Middleware\Auth::check()) : ?>
                                            <li class="active"><a href="/login">Login</a></li>
                                            <li class="active"><a href="/register">Register</a></li>
                                        <?php endif; ?>    

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mobile-header d-lg-none d-md-block sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="mobile-main-header">
                            <div class="mobile-logo">
                                <a href="/">
                                    <img src="public/img/logo/logo.png" alt="Brand Logo">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <aside class="off-canvas-wrapper">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-inner-content">
                <div class="btn-close-off-canvas">
                    <i class="fa fa-close"></i>
                </div>

                <div class="off-canvas-inner">
                    <div class="search-box-offcanvas">
                        <form>
                            <input type="text" placeholder="Search Here...">
                            <button class="search-btn"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

    </header>