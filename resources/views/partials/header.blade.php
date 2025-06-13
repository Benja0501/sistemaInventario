<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_dark.png') }}">
    {{-- ... (todo tu código del head está perfecto) ... --}}
    <title>@yield('title', 'FEMAZA - Inventario')</title>
    {{-- ... (todos tus links CSS están perfectos) ... --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/datepicker/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    {{-- DataTables Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">

</head>

<body class="app sidebar-mini">
    <div id="divLoading">
        <div>
            <img src="{{ asset('assets/images/loading.svg') }}" alt="Loading">
        </div>
    </div>
    <header class="app-header"><a class="app-header__logo" href="{{ route('dashboard') }}">FEMAZA S.A.</a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i
                class="fas fa-bars"></i></a>
        <ul class="app-nav">
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
                    {{-- LÍNEA CORREGIDA: Apunta a la ruta del perfil --}}
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa fa-user fa-lg"></i>
                            Perfil</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-lg"></i> Salir
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    {{-- Incluimos el menú de navegación --}}
    @include('partials.nav')
