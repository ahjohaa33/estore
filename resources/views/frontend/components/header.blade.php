    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
        <!-- Logo Wrapper -->
        <div class="logo-wrapper"><a style="text-decoration: none; font-size: 24px;" href="{{ route('homeroute') }}">{{ config('app.name') }}</a></div>
        <div class="navbar-logo-container d-flex align-items-center">
          <!-- Cart Icon -->
          <div class="cart-icon-wrap"><a href="{{ route('cart.show') }}"><i class="ti ti-basket-bolt"></i><span style="background-color: red;">{{ $globalCartCount ?? 0 }}</span></a></div>
          <!-- User Profile Icon -->
         <div class="user-profile-icon ms-2">
    @auth
        <a href="#">
            <img
                src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('https://avatar.iran.liara.run/username?username=R+C') }}"
                alt="{{ auth()->user()->name }}"
                style="object-fit:fill;border-radius:50%;">
        </a>
    @else
        <a href="{{ route('userlogin') }}">
            <img
                src="{{ asset('https://avatar.iran.liara.run/username?username=R+C') }}"
                alt="Guest"
                style="object-fit:fill;border-radius:50%;">
        </a>
    @endauth
</div>

          <!-- Navbar Toggler -->
          <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
            <div><span></span><span></span><span></span></div>
          </div>
        </div>
      </div>
    </div>