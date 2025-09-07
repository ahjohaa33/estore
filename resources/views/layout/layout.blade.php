@include('../partials/head')
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only"></div>
      </div>
    </div>
    @include('../partials/header')
    @include('../partials/sidenav')

        @yield('content')

    @include('../partials/footer')