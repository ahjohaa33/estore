@props([])

<!-- Header Area-->
<div class="header-area" id="headerArea">
  <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
    <div class="back-button me-2">
      <a href="{{ url('/') }}"><i class="ti ti-arrow-left"></i></a>
    </div>
    <div class="page-heading">
      <h6 class="mb-0">
        {{ $currentCategory ? $currentCategory : 'Shop Grid' }}
      </h6>
    </div>
    <div class="filter-option ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaFilterOffcanvas" aria-controls="suhaFilterOffcanvas">
      <i class="ti ti-adjustments-horizontal"></i>
    </div>
  </div>
</div>

<!-- Offcanvas Filter (kept as UI) -->
<div class="offcanvas offcanvas-start suha-filter-offcanvas-wrap" tabindex="-1" id="suhaFilterOffcanvas" aria-labelledby="suhaFilterOffcanvasLabel">
  <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  <div class="offcanvas-body py-5">
    <div class="container">
      <div class="row">
        <!-- your static filter widgets here -->
        <div class="col-12">
          <div class="apply-filter-btn"><a class="btn btn-lg btn-success w-100" href="#">Apply Filter</a></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-content-wrapper">
  <div class="py-3">
    <div class="container">
      <div class="row g-1 align-items-center rtl-flex-d-row-r">
        <div class="col-8">
          <!-- Product Categories Slide -->
          <div class="product-catagories owl-carousel catagory-slides">
            <!-- All -->
            <a class="shadow-sm {{ !$currentCategory ? 'active' : '' }}"
               href="{{ request()->fullUrlWithQuery(['category' => null]) }}">
              <img src="{{ asset('img/product/5.png') }}" alt="">
              All
            </a>

            @foreach($categories as $cat)
              <a class="shadow-sm {{ $currentCategory == $cat ? 'active' : '' }}"
                 href="{{ request()->fullUrlWithQuery(['category' => $cat]) }}">
                <img src="{{ asset('img/product/9.png') }}" alt="">
                {{ $cat }}
              </a>
            @endforeach
          </div>
        </div>
        <div class="col-4">
          <!-- Sorting -->
          <div class="select-product-catagory">
            <select class="right small border-0" id="selectProductCatagory" name="selectProductCatagory">
              <option value="">Short by</option>
              <option value="newest"  {{ $currentSort == 'newest' ? 'selected' : '' }}>Newest</option>
              <option value="popular" {{ $currentSort == 'popular' ? 'selected' : '' }}>Popular</option>
              <option value="ratings" {{ $currentSort == 'ratings' ? 'selected' : '' }}>Ratings</option>
            </select>
          </div>
        </div>
      </div>

      <div class="mb-3"></div>

      <div class="row g-2 rtl-flex-d-row-r">
        @forelse($products as $product)
          <div class="col-6 col-md-4">
            <div class="card product-card">
              <div class="card-body">
                <!-- Badge (optional col) -->
                @if(!empty($product->badge))
                  <span class="badge rounded-pill badge-warning">{{ $product->badge }}</span>
                @endif

               

                <a class="product-thumbnail d-block"
                   href="{{ route('singleproductRoute', $product->slug ?? $product->id) }}">
                   
                  <img class="mb-2" style="object-fit: fill"
                       src="{{ asset('storage').'/'. $product->images[0] ?? asset('img/product/11.png') }}"
                       alt="{{ $product->name ?? 'Product' }}">
                        <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                </a>

                <a class="product-title"
                   href="{{ route('singleproductRoute', $product->slug ?? $product->id) }}">
                  {{ $product->name ?? 'Product Name' }}
                </a>

                <p class="sale-price">
                  {{ number_format($product->offer_price ?? $product->price ?? 0, 2) }}৳
                  @if(!empty($product->price) && !empty($product->offer_price) && $product->offer_price < $product->price)
                    <span>{{ number_format($product->price, 2) }}৳</span>
                  @endif
                </p>

                <div class="product-rating">
                  @php $rating = $product->rating ?? 5; @endphp
                  @for($i=1; $i<=5; $i++)
                    <i class="ti ti-star-filled {{ $i <= $rating ? '' : 'text-secondary' }}"></i>
                  @endfor
                </div>

                <a class="btn btn-primary btn-sm"
                   href="#"
                   data-url="{{ route('cart.add') }}"
                   data-product-id="{{ $product->id }}"
                   data-qty="1"
                   aria-label="Add to cart">
                  <i class="ti ti-plus"></i>
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center mt-4">No products found.</p>
          </div>
        @endforelse
      </div>

      <div class="mt-3">
        {{ $products->withQueryString()->links() }}
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('selectProductCatagory');
    if (sel) {
      sel.addEventListener('change', function () {
        const url = new URL(window.location.href);
        if (this.value) {
          url.searchParams.set('sort', this.value);
        } else {
          url.searchParams.delete('sort');
        }
        window.location.href = url.toString();
      });
    }
  });
</script>
