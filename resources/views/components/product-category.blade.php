<!-- Header Area-->
<div class="header-area" id="headerArea">
  <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
    <!-- Back Button-->
    <div class="back-button me-2">
      <a href="{{ url()->previous() }}"><i class="ti ti-arrow-left"></i></a>
    </div>
    <!-- Page Title-->
    <div class="page-heading">
      <h6 class="mb-0">{{ $categoryName ?? 'Product Category' }}</h6>
    </div>
    <!-- Filter Option-->
    <div class="filter-option ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaFilterOffcanvas" aria-controls="suhaFilterOffcanvas">
      <i class="ti ti-adjustments-horizontal"></i>
    </div>
  </div>
</div>

{{-- Offcanvas same as yours --}}
<div class="offcanvas offcanvas-start suha-filter-offcanvas-wrap" tabindex="-1" id="suhaFilterOffcanvas" aria-labelledby="suhaFilterOffcanvasLabel">
  <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  <div class="offcanvas-body py-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- You can later bind real brand/color/size from DB -->
          <div class="widget catagory mb-4">
            <h6 class="widget-title mb-2">Brand</h6>
            <div class="widget-desc">
              <div class="form-check">
                <input class="form-check-input" id="zara" type="checkbox" checked>
                <label class="form-check-label" for="zara">Brand 1</label>
              </div>
            </div>
          </div>
        </div>
        {{-- ... keep rest of your offcanvas filters as-is ... --}}
      </div>
    </div>
  </div>
</div>

<div class="page-content-wrapper">
  <!-- Catagory Banner-->
  <div class="pt-3">
    <div class="container">
      <div class="catagory-single-img" style="background-image: url('{{  asset('img/bg-img/5.jpg') }}')"></div>
    </div>
  </div>

  <!-- Product Catagories-->
  <div class="product-catagories-wrapper py-3">
    <div class="container">
      <div class="section-heading rtl-text-right d-flex justify-content-between align-items-center">
        <h6>Category</h6>
      </div>
      <div class="product-catagory-wrap">
        <div class="row g-2 rtl-flex-d-row-r">
          {{-- You can make these dynamic too later --}}
          <div class="col-3">
            <div class="card catagory-card">
              <div class="card-body px-2">
                <a href="#">
                  <img src="{{ asset('storage').'/'.$category_image ??asset('img/core-img/tv-table.png') }}" alt="">
                  <span>{{ $categoryName ?? 'Category' }}</span>
                </a>
              </div>
            </div>
          </div>
          {{-- ... other static sub categories ... --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Top Products-->
  <div class="top-products-area pb-3">
    <div class="container">

      {{-- search + sort --}}
      <form method="GET" class="row g-2 mb-3">
        <div class="col-8">
          <input type="text"
                 name="q"
                 value="{{ $search }}"
                 class="form-control"
                 placeholder="Search in {{ $categoryName }} ...">
        </div>
        <div class="col-4">
          <select name="sort" class="form-select" onchange="this.form.submit()">
            <option value="">Sort</option>
            <option value="latest" {{ $sort=='latest' ? 'selected' : '' }}>Latest</option>
            <option value="price_asc" {{ $sort=='price_asc' ? 'selected' : '' }}>Price (Low → High)</option>
            <option value="price_desc" {{ $sort=='price_desc' ? 'selected' : '' }}>Price (High → Low)</option>
            <option value="name_asc" {{ $sort=='name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
          </select>
        </div>
      </form>

      <div class="section-heading rtl-text-right">
        <h6>Products</h6>
      </div>

      <div class="row g-2 rtl-flex-d-row-r">
        @forelse ($products as $product)
          @php
            // image fallback
            $img = $product->images[0] ?? $product->thumbnail ?? 'img/product/placeholder.png';
            $price = $product->offer_price ?? $product->price ?? 0;
            $old   = $product->price ?? null;
          @endphp
          <div class="col-6 col-md-4">
            <div class="card product-card">
              <div class="card-body">
                @if($product->is_new ?? false)
                  <span class="badge rounded-pill badge-success">New</span>
                @elseif(($product->discount ?? 0) > 0)
                  <span class="badge rounded-pill badge-danger">-{{ $product->discount }}%</span>
                @else
                  <span class="badge rounded-pill badge-warning">Sale</span>
                @endif

                <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>

                <a class="product-thumbnail d-block" href="{{ route('singleproductRoute', $product->slug ?? $product->id) }}">
                  <img class="mb-2" src="{{ asset('storage').'/'.$img }}" alt="{{ $product->name }}">
                </a>

                <a class="product-title" href="{{ route('singleproductRoute', $product->slug ?? $product->id) }}">
                  {{ $product->name }}
                </a>

                <p class="sale-price">
                  ৳{{ number_format($price, 0) }}
                  @if($old && $old > $price)
                    <span>৳{{ number_format($old, 0) }}</span>
                  @endif
                </p>

                <div class="product-rating">
                  <i class="ti ti-star-filled"></i>
                  <i class="ti ti-star-filled"></i>
                  <i class="ti ti-star-filled"></i>
                  <i class="ti ti-star-filled"></i>
                  <i class="ti ti-star-filled"></i>
                </div>

                {{-- add to cart / view --}}
                <a class="btn btn-primary btn-sm"
                   href="{{ route('cart.add', $product->id) }}">
                  <i class="ti ti-plus"></i>
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-warning mb-0">
              No products found in this category.
            </div>
          </div>
        @endforelse
      </div>

      {{-- pagination --}}
      <div class="mt-3">
        {{ $products->links() }}
      </div>

    </div>
  </div>
</div>
