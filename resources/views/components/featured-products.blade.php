<style>
.product-carousel .item img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  display: block;
  border-radius: 8px;
}
.owl-carousel, .owl-stage, .owl-item {
  display: block !important;
  visibility: visible !important;
  opacity: 1 !important;
}
</style>

<div class="top-products-area py-3">
  <div class="container">
    <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
      <h6>Featured Products</h6>
      <a class="btn btn-sm btn-light" href="shop-grid.html">
        View all<i class="ms-1 ti ti-arrow-right"></i>
      </a>
    </div>

    <div class="row g-2">
      @forelse($featured as $item)
        <div class="col-6 col-md-4">
          <div class="card product-card">
            <div class="card-body">
              

              <!-- Carousel -->
              <div class="product-carousel owl-carousel owl-theme mb-2">
                @if(!empty($item->images))
                  @foreach($item->images as $img)
                    <div class="item">
                        <!-- Badge--><span class="badge badge-warning custom-badge"><i class="ti ti-star-filled"></i></span>
                        <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                        <img style="object-fit: contain; height: 100%;" src="{{ asset('storage/' . ltrim($img, '/')) }}" alt="{{ $item->name }}">
                    </div>
                  @endforeach
                @else
                  <div class="item">
                    <img src="{{ asset('default-product.png') }}" alt="No image">
                  </div>
                @endif
              </div>

              <a class="product-title" href="#">{{ $item->name }}</a>
              <p class="sale-price">{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span></p>
              <div class="product-rating">
                <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
              </div>
              <a class="btn btn-primary btn-sm" href="#"><i class="ti ti-plus"></i></a>
            </div>
          </div>
        </div>
      @empty
        <div class="text-center text-muted py-3">No products found.</div>
      @endforelse
    </div>
  </div>
</div>


