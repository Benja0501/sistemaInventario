    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('assets/images/avatar.png') }}"
                alt="User Image">
            <div>
                <p class="app-sidebar__user-name">nombre</p>
                <p class="app-sidebar__user-designation">rol</p>
            </div>
        </div>
        <ul class="app-menu">
            <li>
                <a class="app-menu__item" href="{{ route('/') }}" target="_blank">
                    <i class="app-menu__icon fa fas fa-globe" aria-hidden="true"></i>
                    <span class="app-menu__label">Ver sitio web</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('dashboard') }}">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
                    <span class="app-menu__label">Usuarios</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('users.index') }}"><i class="icon fa fa-circle-o"></i>
                            Usuarios</a></li>
                    <li><a class="treeview-item" href="{{ route('roles.index') }}"><i class="icon fa fa-circle-o"></i>
                            Roles</a></li>
                </ul>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('suppliers.index') }}">
                    <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
                    <span class="app-menu__label">Proveedores</span>
                </a>
            </li>
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
                    <span class="app-menu__label">Tienda</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('products.index') }}"><i class="icon fa fa-circle-o"></i>
                            Productos</a></li>
                    <li><a class="treeview-item" href="{{ route('categories.index') }}"><i class="icon fa fa-circle-o"></i>
                            Categorías</a></li>
                    <li><a class="treeview-item" href="{{ route('batches.index') }}"><i class="icon fa fa-circle-o"></i>
                            Lotes</a></li>
                </ul>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('purchase_orders.index') }}">
                    <i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
                    <span class="app-menu__label">Compras</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('locations.index') }}">
                    <i class="app-menu__icon fas fa-user-tie" aria-hidden="true"></i>
                    <span class="app-menu__label">Ubicaciones</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('product_locations.index') }}">
                    <i class="app-menu__icon fas fa-envelope" aria-hidden="true"></i>
                    <span class="app-menu__label">Ubicación de productos</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('receptions.index') }}">
                    <i class="app-menu__icon fas fa-file-alt" aria-hidden="true"></i>
                    <span class="app-menu__label">Recepción</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('discrepancies.index') }}">
                    <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
                    <span class="app-menu__label">Discrepancias</span>
                </a>
            </li>
        </ul>
    </aside>
