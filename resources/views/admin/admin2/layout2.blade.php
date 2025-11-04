<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <title>Ecom - Marketplace Dashboard Template</title>
</head>

<body>

    <div class="screen-overlay"></div>
<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a class="brand-wrap" href="{{ route('admindashboard') }}">
            <img class="logo" src="assets/imgs/theme/logo.svg" alt="Admin Dashboard">
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize">
                <i class="text-muted material-icons md-menu_open"></i>
            </button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('dashboard2') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('dashboard2') }}">
                    <i class="icon material-icons md-home"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('categories2') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('categories2') }}">
                    <i class="icon material-icons md-home"></i>
                    <span class="text">Categories</span>
                </a>
            </li>

            <!-- Products -->
            <li class="menu-item has-submenu {{ request()->routeIs('products2*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('products2') }}">
                    <i class="icon material-icons md-shopping_bag"></i>
                    <span class="text">Products</span>
                </a>
                <div class="submenu">
                    <a href="{{ route('products2') }}" class="{{ request()->routeIs('products2') && !request()->has('view') ? 'active' : '' }}">
                        All Products
                    </a>
                    <a href="{{ route('products2', ['view' => 'grid']) }}" class="{{ request()->get('view') == 'grid' ? 'active' : '' }}">
                        Product Grid
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Add New Product
                    </a>
                </div>
            </li>

            <!-- Orders -->
            <li class="menu-item has-submenu {{ request()->routeIs('adminorders*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('adminorders') }}">
                    <i class="icon material-icons md-shopping_cart"></i>
                    <span class="text">Orders</span>
                </a>
                <div class="submenu">
                    <a href="{{ route('adminorders') }}" class="{{ request()->routeIs('adminorders') && !request()->has('status') ? 'active' : '' }}">
                        All Orders
                    </a>
                    <a href="{{ route('adminorders', ['status' => 'pending']) }}" class="{{ request()->get('status') == 'pending' ? 'active' : '' }}">
                        Pending Orders
                    </a>
                    <a href="{{ route('adminorders', ['status' => 'completed']) }}" class="{{ request()->get('status') == 'completed' ? 'active' : '' }}">
                        Completed Orders
                    </a>
                    <a href="{{ route('adminorders', ['status' => 'cancelled']) }}" class="{{ request()->get('status') == 'cancelled' ? 'active' : '' }}">
                        Cancelled Orders
                    </a>
                </div>
            </li>

            <!-- Customers -->
            <li class="menu-item {{ request()->routeIs('admincustomers*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('admincustomers') }}">
                    <i class="icon material-icons md-person"></i>
                    <span class="text">Customers</span>
                </a>
            </li>

            <!-- Categories -->
            <li class="menu-item has-submenu {{ request()->routeIs('admincategories*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('admincategories') }}">
                    <i class="icon material-icons md-category"></i>
                    <span class="text">Categories</span>
                </a>
                <div class="submenu">
                    <a href="{{ route('admincategories') }}">Manage Categories</a>
                    <a href="#" id="addCategoryBtn">Add New Category</a>
                </div>
            </li>

            <!-- Sliders -->
            <li class="menu-item {{ request()->routeIs('adminSliders*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('adminSliders') }}">
                    <i class="icon material-icons md-slideshow"></i>
                    <span class="text">Sliders</span>
                </a>
            </li>

            <!-- Reviews -->
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-comment"></i>
                    <span class="text">Reviews</span>
                </a>
            </li>

            <!-- Brands -->
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-stars"></i>
                    <span class="text">Brands</span>
                </a>
            </li>
        </ul>

        <hr>

        <ul class="menu-aside">
            <!-- Settings -->
            <li class="menu-item has-submenu {{ request()->routeIs('adminsettings*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('adminsettings') }}">
                    <i class="icon material-icons md-settings"></i>
                    <span class="text">Settings</span>
                </a>
                <div class="submenu">
                    <a href="{{ route('adminsettings') }}">General Settings</a>
                    <a href="{{ route('adminsettings', ['tab' => 'payment']) }}">Payment Settings</a>
                    <a href="{{ route('adminsettings', ['tab' => 'shipping']) }}">Shipping Settings</a>
                </div>
            </li>

            <!-- Statistics -->
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-pie_chart"></i>
                    <span class="text">Statistics</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

    @yield('admin2')

    <script src="{{ asset('assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>
</body>

</html>
