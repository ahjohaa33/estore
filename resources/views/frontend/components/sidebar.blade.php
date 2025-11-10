<div class="offcanvas offcanvas-start suha-offcanvas-wrap" tabindex="-1" id="suhaOffcanvas" aria-labelledby="suhaOffcanvasLabel">
  <!-- Close button-->
  <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>

  <!-- Offcanvas body-->
  <div class="offcanvas-body">
    <!-- Sidenav Profile-->
    <div class="sidenav-profile">
      @auth
        <div class="user-profile">
          <img
            src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('https://avatar.iran.liara.run/username?username=R+C') }}"
            alt="{{ auth()->user()->name }}"
            style="object-fit:fill;border-radius:50%;">
        </div>
        <div class="user-info">
          <h5 class="user-name mb-1 text-white">{{ auth()->user()->name }}</h5>
          <p class="available-balance text-white">
            {{ auth()->user()->email ?? auth()->user()->phone }}
          </p>
        </div>
      @else
        <div class="user-profile">
          <img src="{{ asset('https://avatar.iran.liara.run/username?username=R+C') }}" alt="Guest" style="object-fit:fill;border-radius:50%;">
        </div>
        <div class="user-info">
          <h5 class="user-name mb-1 text-white">Guest User</h5>
          <p class="available-balance text-white">Please sign in</p>
        </div>
      @endauth
    </div>

    <!-- Sidenav Nav-->
    <ul class="sidenav-nav ps-0">
      @auth
        <li>
          <a href="{{ route('userprofile') }}">
            <i class="ti ti-user"></i> My Profile
          </a>
        </li>
        <li>
          <a href="">
            <i class="ti ti-bell-ringing lni-tada-effect"></i> Notifications
            {{-- optional badge --}}
            {{-- <span class="ms-1 badge badge-warning">3</span> --}}
          </a>
        </li>
        <li class="suha-dropdown-menu">
          <a href="{{ route('shop') }}"><i class="ti ti-building-store"></i>Shop</a>
        </li>
        <li>
          <a href="">
            <i class="ti ti-heart"></i> My Wishlist
          </a>
        </li>
        <li>
          <a href="{{ route('settingsroute') }}">
            <i class="ti ti-adjustments-horizontal"></i> Settings
          </a>
        </li>
        <li>
          <form action="" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="bg-transparent border-0 text-start w-100 px-0 d-flex align-items-center gap-2 text-white">
              <i class="ti ti-logout"></i> Sign Out
            </button>
          </form>
        </li>
      @endauth

      @guest
        <li>
          <a href="{{ route('userlogin') }}">
            <i class="ti ti-login"></i> Sign In
          </a>
        </li>
        <li>
          <a href="">
            <i class="ti ti-user-plus"></i> Create Account
          </a>
        </li>
      @endguest
    </ul>
  </div>
</div>
