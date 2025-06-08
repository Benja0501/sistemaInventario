<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Tienda Virtual Abel OSH">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Abel OSH">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_dark.png') }}">
    <title>@yield('title', 'Panel Inventario')</title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/datepicker/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="app sidebar-mini">
    <div id="divLoading">
        <div>
            <img src="{{ asset('assets/images/loading.svg') }}" alt="Loading">
        </div>
    </div>
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{ route('dashboard') }}">Tienda Femaza</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"><i class="fas fa-bars"></i></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href=""><i class="fa fa-cog fa-lg"></i>
                            Settings</a></li>
                    <li><a class="dropdown-item" href=""><i class="fa fa-user fa-lg"></i> Profile</a></li>
                    <li><a class="dropdown-item" href=""><i class="fa fa-sign-out fa-lg"></i>
                            Logout</a></li>
                </ul>
            </li>
        </ul>
    </header>
@include('partials.nav')