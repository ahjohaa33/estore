      <!-- Weekly Best Sellers-->
      <div class="weekly-best-seller-area py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Weekly Best Sellers</h6><a class="btn btn-sm btn-light" href="shop-list.html">
               View all<i class="ms-1 ti ti-arrow-right"></i></a>
          </div>
          <div class="row g-2">
            @forelse($bestseller as $item)
                            <!-- Weekly Product Card -->
            <div class="col-12">
              <div class="card horizontal-product-card">
                <div class="d-flex align-items-center">
                  <div class="product-thumbnail-side">
                    <!-- Thumbnail --><a class="product-thumbnail d-block" href="#"><img src="{{ asset('storage') . '/'. $item->images[2] }}" alt=""></a>
                    <!-- Wishlist  --><a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                  </div>
                  <div class="product-description">
                    <!-- Product Title --><a class="product-title d-block" href="single-product.html">{{ $item->name }}</a>
                    <!-- Price -->
                    <p class="sale-price"><i class="ti ti-currency-dollar"></i>{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span></p>
                    <!-- Rating -->
                    <div class="product-rating"><i class="ti ti-star-filled"></i>4.88 <span class="ms-1">(39 review)</span></div>
                  </div>
                </div>
              </div>
            </div>
            @empty
                <div class="text-center text-muted py-3">No products found.</div>
            @endforelse


          </div>
        </div>
      </div>