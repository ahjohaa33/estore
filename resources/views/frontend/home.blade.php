@extends('frontend.layout')
@section('pages')
    <div>
    <div class="page-content-wrapper">
      <!-- Search Form-->
      <!-- Search Form-->
      <div class="container">
        <div class="search-form rtl-flex-d-row-r">
          <form action="#" method="">
            <input class="form-control" type="search" placeholder="Search in Topu Sports...">
            <button type="submit"><i class="ti ti-search"></i></button>
          </form>
          <!-- Alternative Search Options -->
          <div class="alternative-search-options">
            <div class="dropdown"><a class="btn btn-primary dropdown-toggle" id="altSearchOption" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-adjustments-horizontal"></i></a>
              <!-- Dropdown Menu -->
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="altSearchOption">
                <li><a class="dropdown-item" href="#"><i class="ti ti-microphone"> </i>Voice</a></li>
                <li><a class="dropdown-item" href="#"><i class="ti ti-layout-collage"> </i>Image</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <x-slider />
      <x-collections />
      <!-- Top Products -->
      <x-top-products />

      <!-- Dark Mode -->
      <div class="container my-4">
        <div class="dark-mode-wrapper mt-3 bg-img p-4 p-lg-5">
          <p class="text-white">You can change your display to a dark background using a dark mode.</p>
          <div class="form-check form-switch mb-0">
            <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Switch to Dark Mode</label>
            <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
          </div>
        </div>
      </div>

      <!-- CTA Area -->
      <div class="container">
        <div class="cta-text dir-rtl p-4 p-lg-5">
          <div class="row">
            <div class="col-9">
              <h5 class="text-white">20% discount on women's care items.</h5><a class="btn btn-primary" href="#">Grab this offer</a>
            </div>
          </div><img src="img/bg-img/make-up.png" alt="">
        </div>
      </div>
      <!-- Weekly Best Sellers-->
     <x-best-seller />
      <!-- Discount Coupon Card-->
      <div class="container">
        <div class="discount-coupon-card p-4 p-lg-5 dir-rtl">
          <div class="d-flex align-items-center">
            <div class="discountIcon"><img class="w-100" src="img/core-img/discount.png" alt=""></div>
            <div class="text-content">
              <h5 class="text-white mb-2">Get 20% discount!</h5>
              <p class="text-white mb-0">To get discount, enter the<span class="px-1 fw-bold">GET20</span>code on the checkout page.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Featured Products Wrapper-->
      <x-featured-products />

      <x-checkout />
 
      {{-- <div class="pb-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Collections</h6><a class="btn btn-sm btn-light" href="#">
               View all<i class="ms-1 ti ti-arrow-right"></i></a>
          </div>
          <!-- Collection Slide-->
          <div class="collection-slide owl-carousel">
            <!-- Collection Card-->
            <div class="card collection-card"><a href="single-product.html"><img src="img/product/17.jpg" alt=""></a>
              <div class="collection-title"><span>Women</span><span class="badge bg-danger">9</span></div>
            </div>
            <!-- Collection Card-->
            <div class="card collection-card"><a href="single-product.html"><img src="img/product/19.jpg" alt=""></a>
              <div class="collection-title"><span>Men</span><span class="badge bg-danger">29</span></div>
            </div>
            <!-- Collection Card-->
            <div class="card collection-card"><a href="single-product.html"><img src="img/product/21.jpg" alt=""></a>
              <div class="collection-title"><span>Kids</span><span class="badge bg-danger">4</span></div>
            </div>
            <!-- Collection Card-->
            <div class="card collection-card"><a href="single-product.html"><img src="img/product/22.jpg" alt=""></a>
              <div class="collection-title"><span>Gadget</span><span class="badge bg-danger">11</span></div>
            </div>
            <!-- Collection Card-->
            <div class="card collection-card"><a href="single-product.html"><img src="img/product/23.jpg" alt=""></a>
              <div class="collection-title"><span>Foods</span><span class="badge bg-danger">2</span></div>
            </div>
            <!-- Collection Card-->
            <div class="card collection-card"><a href="single-product.html"><img src="img/product/24.jpg" alt=""></a>
              <div class="collection-title"><span>Sports</span><span class="badge bg-danger">5</span></div>
            </div>
          </div>
        </div>
      </div> --}}
    </div>
    </div>
@endsection