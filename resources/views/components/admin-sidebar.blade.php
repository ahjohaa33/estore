<aside class="sidebar">
    <div class="sidebar-header">
        <h2><i class="fas fa-store"></i> Admin Panel</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admindashboard') }}" 
           class="nav-item {{ request()->routeIs('admindashboard') ? 'active' : '' }}">
            <i class="fas fa-dashboard"></i> Dashboard
        </a>
        <a href="{{ route('adminproducts') }}" 
           class="nav-item {{ request()->routeIs('adminproducts*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Products
        </a>
        <a href="{{ route('adminorders') }}" 
           class="nav-item {{ request()->routeIs('adminorders*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i> Orders
        </a>
        <a href="{{ route('admincustomers') }}" 
           class="nav-item {{ request()->routeIs('admincustomers*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Customers
        </a>
        <a href="{{ route('admincategories') }}" 
           class="nav-item {{ request()->routeIs('admincategories*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Categories
        </a>
        <a href="{{ route('adminSliders') }}" 
           class="nav-item {{ request()->routeIs('adminSliders*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Sliders
        </a>
        <a href="{{ route('adminsettings') }}" 
           class="nav-item {{ request()->routeIs('adminsettings*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Settings
        </a>
    </nav>
</aside>




