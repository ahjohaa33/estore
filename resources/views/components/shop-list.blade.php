@props([])

<!-- Header Area-->
<div class="header-area" id="headerArea">
  <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
    <div class="back-button me-2">
      <a href="{{ url('/') }}"><i class="ti ti-arrow-left"></i></a>
    </div>
    <div class="page-heading">
      <h6 class="mb-0">
        {{ $currentCategory ? $currentCategory : 'Shop List' }}
      </h6>
    </div>
    <div class="filter-option ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaFilterOffcanvas" aria-controls="suhaFilterOffcanvas">
      <i class="ti ti-adjustments-horizontal"></i>
    </div>
  </div>
</div>

{{-- offcanvas (kept as UI only) --}}
<div class="offcanvas offcanvas-start suha-filter-offcanvas-wrap" tabindex="-1" id="suhaFilterOffcanvas" aria-labelledby="suhaFilterOffcanvasLabel">
  <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  <div class="offcanvas-body py-5">
    <div class="container">
      <div class="row">
        {{-- your static filter widgets here --}}
        <div class="col-12">
          <div class="apply-filter-btn">
            <a class="btn btn-lg btn-success w-100" href="#">Apply Filter</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-content-wrapper">
  <div class="py-3">
    <div class="container">

      {{-- top row: category slider + sort + search --}}
      <div class="row g-1 align-items-center rtl-flex-d-row-r mb-2">
        <div class="col-8">
          <!-- Product Categories Slide -->
          <div class="product-catagories owl-carousel catagory-slides">
            <a class="shadow-sm {{ !$currentCategory ? 'active' : '' }}"
               href="{{ request()->fullUrlWithQuery(['category' => null]) }}">
              <img src="{{ asset('img/product/4.png') }}" alt="">All
            </a>
            @foreach($categories as $cat)
              <a class="shadow-sm {{ $currentCategory == $cat ? 'active' : '' }}"
                 href="{{ request()->fullUrlWithQuery(['category' => $cat]) }}">
                <img style="height: 20px;" src="{{ asset('storage').'/'. $cat->category_image ?? asset('img/product/9.png ')}}" alt="">{{ $cat->name }}
              </a>
            @endforeach
          </div>
        </div>
        <div class="col-4">
          <div class="select-product-catagory d-flex gap-1">
            <select class="right small border-0" id="selectProductSort" name="selectProductSort">
              <option value="">Short by</option>
              <option value="newest"  {{ $currentSort == 'newest' ? 'selected' : '' }}>Newest</option>
              <option value="popular" {{ $currentSort == 'popular' ? 'selected' : '' }}>Popular</option>
              <option value="ratings" {{ $currentSort == 'ratings' ? 'selected' : '' }}>Ratings</option>
            </select>
          </div>
        </div>
      </div>

      {{-- search box --}}
      <div class="row mb-3">
        <div class="col-12">
          <form method="GET" action="">
            <div class="input-group">
              <input type="text"
                     name="q"
                     class="form-control"
                     placeholder="Search products..."
                     value="{{ $currentSearch }}">
              @if($currentCategory)
                <input type="hidden" name="category" value="{{ $currentCategory }}">
              @endif
              <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
            </div>
          </form>
        </div>
      </div>

      <div class="row g-2">
        @forelse($products as $product)
          <div class="col-12">
            <div class="card horizontal-product-card">
              <div class="d-flex align-items-center">
                <div class="product-thumbnail-side">
                  <a class="product-thumbnail d-block" href="{{ route('singleproductRoute', $product->slug ?? $product->id) }}">
                    <img src="{{ asset('storage').'/'.$product->images[0] ?? asset('img/product/18.png') }}" alt="{{ $product->name }}">
                  </a>
                  <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                </div>
                <div class="product-description">
                  <a class="product-title d-block" href="{{ route('singleproductRoute', $product->slug ?? $product->id) }}">
                    {{ $product->name }}
                  </a>
                  <p class="sale-price">
                   
                    {{ number_format($product->offer_price ?? $product->price ?? 0, 2) }} BDT
                    @if(!empty($product->price) && !empty($product->offer_price) && $product->offer_price < $product->price)
                      <span>{{ number_format($product->price, 2) }} BDT</span>
                    @endif
                  </p>
                  <div class="product-rating">
                    @php
                      $rating = $product->reviews_avg_rating ?? 5;
                      $reviewCount = $product->reviews_count ?? 0;
                    @endphp
                    <i class="ti ti-star-filled"></i>{{ number_format($rating, 2) }}
                    <span class="ms-1">({{ $reviewCount }} review)</span>
                  </div>
                </div>
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
        {{ $products->links() }}
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('selectProductSort');
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
