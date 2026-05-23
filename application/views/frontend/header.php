<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <?php
    $CI =& get_instance();
    $CI->load->model('Seo_model');
    $_seo = isset($page) ? $CI->Seo_model->get_by_key($page) : null;
    $_seo_title = (!empty($_seo) && !empty($_seo->title)) ? $_seo->title : (isset($page_title) ? html_escape($page_title) . ' - Gem Housing' : 'Gem Housing');
    ?>
    <title><?php echo $_seo_title; ?></title>
    <?php if (!empty($_seo) && !empty($_seo->keywords)): ?>
    <meta name="keywords" content="<?php echo html_escape($_seo->keywords); ?>">
    <?php endif; ?>
    <?php if (!empty($_seo) && !empty($_seo->description)): ?>
    <meta name="description" content="<?php echo html_escape($_seo->description); ?>">
    <?php endif; ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('images/loaderlogo.png'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Agdasima:wght@400;700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url('css/fonts.css'); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo base_url('css/slicknav.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/swiper-bundle.min.css'); ?>">
    <link href="<?php echo base_url('css/all.min.css'); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo base_url('css/animate.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/magnific-popup.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/mousecursor.css'); ?>">
    <link href="<?php echo base_url('css/custom.css?v=1.1'); ?>" rel="stylesheet" media="screen">
</head>
<body>
<div class="preloader">
    <div class="loading-container">
        <div class="loading"></div>
        <div id="loading-icon"><img src="<?php echo base_url('images/loaderlogo.png'); ?>" alt="loader"></div>
    </div>
</div>

<header class="main-header">
    <div class="header-sticky bg-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo base_url('images/logo-gemland.png'); ?>" alt="Logo">
                </a>
                <div class="collapse navbar-collapse main-menu">
                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav mr-auto" id="menu">
                            <li class="nav-item"><a class="nav-link <?php echo ($page === 'home') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>">Home</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($page === 'about') ? 'active' : ''; ?>" href="<?php echo site_url('about'); ?>">About Us</a></li>
                            <li class="nav-item submenu">
                                <a class="nav-link <?php echo ($page === 'projects') ? 'active' : ''; ?>" href="<?php echo site_url('projects'); ?>">Projects</a>
                                <ul>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('projects/ongoing'); ?>">Ongoing</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('projects/upcoming'); ?>">Upcoming</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('projects/completed'); ?>">Completed</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link <?php echo ($page === 'blog') ? 'active' : ''; ?>" href="<?php echo site_url('blog'); ?>">Blog</a></li>
                           
                            <li class="nav-item"><a class="nav-link <?php echo ($page === 'contact') ? 'active' : ''; ?>" href="<?php echo site_url('contact'); ?>">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- <div class="header-btn">
                        <a href="<?php echo site_url('contact'); ?>" class="btn-default">Get Free Quote</a>
                    </div> -->
                </div>
                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>
