    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        {{-- Usuario logueado --}}
        <div class="app-sidebar__user">
            <img class="app-sidebar__user-avatar" src="{{ asset('assets/images/avatar.png') }}" alt="User Image">
            <div>
                <p class="app-sidebar__user-name">
                    {{ auth()->user()->name }}
                </p>
                <p class="app-sidebar__user-designation">
                    {{ optional(auth()->user()->role)->name ?? 'Sin asignar' }}
                </p>
            </div>
        </div>

        <ul class="app-menu">
            {{-- Ver sitio público --}}
            <li>
                <a class="app-menu__item" href="{{ route('welcome') }}" target="_blank">
                    <i class="app-menu__icon fa fa-globe"></i>
                    <span class="app-menu__label">Ver sitio web</span>
                </a>
            </li>

            {{-- Dashboard --}}
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('dashboard') }}">
                    <i class="app-menu__icon fa fa-tachometer-alt"></i>
                    <span class="app-menu__label">Dashboard</span>
                </a>
            </li>

            {{-- Usuarios y Roles --}}
            <li class="treeview {{ request()->is('users*') || request()->is('roles*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-users"></i>
                    <span class="app-menu__label">Usuarios</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="{{ route('users.index') }}">
                            <i class="icon fa fa-user"></i> Usuarios
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="{{ route('roles.index') }}">
                            <i class="icon fa fa-user-shield"></i> Roles
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Proveedores --}}
            <li class="{{ request()->is('suppliers*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('suppliers.index') }}">
                    <i class="app-menu__icon fa fa-truck"></i>
                    <span class="app-menu__label">Proveedores</span>
                </a>
            </li>

            {{-- Tienda --}}
            <li
                class="treeview {{ request()->is('products*') || request()->is('categories*') || request()->is('batches*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-store"></i>
                    <span class="app-menu__label">Tienda</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="{{ route('products.index') }}">
                            <i class="icon fa fa-box"></i> Productos
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="{{ route('categories.index') }}">
                            <i class="icon fa fa-tags"></i> Categorías
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item" href="{{ route('batches.index') }}">
                            <i class="icon fa fa-layer-group"></i> Lotes
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Compras --}}
            <li class="{{ request()->is('purchase_orders*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('purchase_orders.index') }}">
                    <i class="app-menu__icon fa fa-shopping-cart"></i>
                    <span class="app-menu__label">Compras</span>
                </a>
            </li>

            {{-- Ubicaciones --}}
            <li class="{{ request()->is('locations*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('locations.index') }}">
                    <i class="app-menu__icon fa fa-map-marker-alt"></i>
                    <span class="app-menu__label">Ubicaciones</span>
                </a>
            </li>

            {{-- Ubicación de productos --}}
            <li class="{{ request()->is('product_locations*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('product_locations.index') }}">
                    <i class="app-menu__icon fa fa-map-marked-alt"></i>
                    <span class="app-menu__label">Ubicación de productos</span>
                </a>
            </li>

            {{-- Recepciones --}}
            <li class="{{ request()->is('receptions*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('receptions.index') }}">
                    <i class="app-menu__icon fa fa-receipt"></i>
                    <span class="app-menu__label">Recepciones</span>
                </a>
            </li>

            {{-- Discrepancias --}}
            <li class="{{ request()->is('discrepancies*') ? 'active' : '' }}">
                <a class="app-menu__item" href="{{ route('discrepancies.index') }}">
                    <i class="app-menu__icon fa fa-exclamation-triangle"></i>
                    <span class="app-menu__label">Discrepancias</span>
                </a>
            </li>
        </ul>
    </aside>
