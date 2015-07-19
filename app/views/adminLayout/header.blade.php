<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="hr" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7 ]>    <html lang="hr" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="hr" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9 ]>    <html lang="hr" class="no-js lt-ie10"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="hr" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>4AllGym :: Administracija</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta property="og:title" content="4allGym" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url('/') }}" />
    <meta property="og:site_name" content="4allgym.hr" />
    <meta property="og:description" content="4allGym - kondicijski centar" />

    <!-- scripts -->
    {{ HTML::script('js/jquery.min.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/modernizr.js', ['charset' => 'utf-8']) }}
    <!--[if lt IE 9]>
    {{ HTML::script('js/html5shiv.min.js', array('charset' => 'utf-8')) }}
    {{ HTML::script('js/respond.min.js', array('charset' => 'utf-8')) }}
    <![endif]-->

    <!-- stylesheets -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/main.css') }}
</head>
<body>
<!-- notifications -->
<div class="notificationOutput" id="outputMsg">
    <div class="notificationTools" id="notifTool">
        <span class="fa fa-times fa-med" id="notificationRemove"></span>
        <span id="notificationTimer"></span>
    </div>
</div>

<div id="outer-wrap">
    <div id="inner-wrap">

        <header id="top" role="banner">
            <div class="block">
                <div id="nav-logo" title="4allGym"></div>
                <a class="nav-btn" id="nav-open-btn" href="#nav"><i class="fa fa-bars" title="Prikaži navigaciju"></i></a>
            </div>
        </header>

        <nav id="nav" role="navigation">
            <div class="block">
                <h2 class="block-title">Navigacija</h2>
                <p class="text-center light">Pozdrav <strong><span id="nav-user-content">{{ Auth::user()->username }}</span></strong></p>
                <ul>
                    {{ HTML::smartRoute_link('admin/pocetna', 'Početna', '<i class="fa fa-home"></i>') }}
                    {{ HTML::smartRoute_link('admin/korisnicke-postavke', 'Korisničke postavke', '<i class="fa fa-user"></i>') }}
                    {{ HTML::smartRoute_link('logout', 'Odjava', '<i class="fa fa-sign-out"></i>') }}
                </ul>
                <a class="close-btn" id="nav-close-btn" href="#top"><i class="fa fa-close" title="Sakrij navigaciju"></i></a>
            </div>
        </nav>