    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
      <!-- Background Shape-->
      <div class="background-shape"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-10 col-lg-6"><img class="big-logo" src="{{ asset('img/core-img/logo-white.png') }}" alt="">
            <!-- Register Form-->
            <div class="register-form mt-5">
              <form action="{{ route('authentication') }}" method="POST">
                @csrf
                <div class="form-group text-start mb-4"><span>Email / Phone</span>
                  <label for="username"><i class="ti ti-user"></i></label>
                  <input class="form-control" id="username" name="login" type="text" placeholder="info@example.com">
                </div>
                <div class="form-group text-start mb-4"><span>Password</span>
                  <label for="password"><i class="ti ti-key"></i></label>
                  <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                </div>
                <button class="btn btn-warning btn-lg w-100" type="submit">Log In</button>
              </form>
            </div>
            <!-- Login Meta-->
            <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="forget-password.html">Forgot Password?</a>
              <p class="mb-0">Didn't have an account?<a class="mx-1" href="register.html">Register Now</a></p>
            </div>
            <!-- View As Guest-->
            <div class="view-as-guest mt-3"><a class="btn btn-primary btn-sm" href="home.html">View as guest<i class="ps-2 ti ti-arrow-right"></i></a></div>
          </div>
        </div>
      </div>
    </div>