<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="{{ asset('assets/images/avatar.png') }}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">
                {{ auth()->user()->name }}
            </p>
            {{-- LÍNEA CORREGIDA: Muestra el rol directamente --}}
            <p class="app-sidebar__user-designation">
                {{ ucfirst(auth()->user()->role) }}
            </p>
        </div>
    </div>

    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="app-menu__icon fa fa-tachometer-alt"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>

        {{-- MENÚ SOLO PARA SUPERVISOR --}}
        @if (auth()->user()->role == 'supervisor')
            <li class="{{ request()->is('users*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('users.index') }}">
                    <i class="app-menu__icon fa fa-users"></i>
                    <span class="app-menu__label">Usuarios</span>
                </a>
            </li>
        @endif

        {{-- MENÚ PARA SUPERVISOR Y COMPRAS --}}
        @if (in_array(auth()->user()->role, ['supervisor', 'purchasing']))
            <li
                class="treeview {{ request()->is('suppliers*') || request()->is('categories*') || request()->is('products*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-store"></i>
                    <span class="app-menu__label">Catálogos</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('suppliers.index') }}"><i class="icon fa fa-truck"></i>
                            Proveedores</a></li>
                    <li><a class="treeview-item" href="{{ route('categories.index') }}"><i class="icon fa fa-tags"></i>
                            Categorías</a></li>
                    <li><a class="treeview-item" href="{{ route('products.index') }}"><i class="icon fa fa-box"></i>
                            Productos</a></li>
                </ul>
            </li>
            {{-- LÍNEA CORREGIDA: Nombre de la ruta --}}
            <li class="{{ request()->is('purchases*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('purchases.index') }}">
                    <i class="app-menu__icon fa fa-shopping-cart"></i>
                    <span class="app-menu__label">Órdenes de Compra</span>
                </a>
            </li>
        @endif

        {{-- MENÚ PARA SUPERVISOR Y ALMACÉN --}}
        @if (in_array(auth()->user()->role, ['supervisor', 'warehouse']))
            <li
                class="treeview {{ request()->is('stock-entries*') || request()->is('stock-exits*') || request()->is('discrepancy-reports*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-archive"></i>
                    <span class="app-menu__label">Gestión de Stock</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    {{-- LÍNEAS CORREGIDAS: Nombres de rutas --}}
                    <li><a class="treeview-item" href="{{ route('entries.index') }}"><i
                                class="icon fa fa-arrow-down"></i> Entradas</a></li>
                    <li><a class="treeview-item" href="{{ route('exits.index') }}"><i
                                class="icon fa fa-arrow-up"></i> Salidas</a></li>
                    <li><a class="treeview-item" href="{{ route('discrepancies.index') }}"><i
                                class="icon fa fa-exclamation-triangle"></i> Discrepancias</a></li>
                </ul>
            </li>
        @endif

    </ul>
</aside>
