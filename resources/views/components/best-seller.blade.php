      <!-- Weekly Best Sellers-->
      <div class="weekly-best-seller-area py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Weekly Best Sellers</h6><a class="btn btn-sm btn-light" href="{{ route('best-seller') }}">
               View all<i class="ms-1 ti ti-arrow-right"></i></a>
          </div>
          <div class="row g-2">
            @forelse($bestseller as $item)
                            <!-- Weekly Product Card -->
            <div class="col-12">
              <div class="card horizontal-product-card">
                <div class="d-flex align-items-center">
                  <div class="product-thumbnail-side">
                    <!-- Thumbnail --><a class="product-thumbnail d-block" href="{{ route('singleproductRoute', $item->name) }}"><img src="{{ asset('storage') . '/'. ($item->images[2] ?? '') }}" alt=""></a>
                    <!-- Wishlist  --><a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                  </div>
                  <div class="product-description">
                    <!-- Product Title --><a class="product-title d-block" href="{{ route('singleproductRoute', $item->name) }}">{{ $item->name }}</a>
                    <!-- Price -->
                    <p class="sale-price">{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span></p>
                    <!-- Rating -->
                                  <div class="product-rating">
                                  @php
                                    $avg = round($item->reviews_avg_rating ?? 0, 1); // 0–5, one decimal
                                    $full = (int) floor($avg);
                                    $dec  = $avg - $full;
                                    // .75+ rounds up to another full star; .25–.74 shows a half
                                    if ($dec >= 0.75) { $full++; $half = 0; }
                                    else { $half = ($dec >= 0.25) ? 1 : 0; }
                                    $empty = 5 - $full - $half;
                                  @endphp

                                  {{-- full stars --}}
                                  @for ($i = 0; $i < $full; $i++)
                                    <i class="ti ti-star-filled"></i>
                                  @endfor

                                  {{-- half star --}}
                                  @if ($half)
                                    <i class="ti ti-star-half-filled"></i>
                                  @endif

                                  {{-- empty stars --}}
                                  @for ($i = 0; $i < $empty; $i++)
                                    <i class="ti ti-star"></i>
                                  @endfor
                                </div>

                                <small class="text-muted">
                                  ({{ $item->reviews_count }} {{ Str::plural('review', $item->reviews_count) }})
                                </small>
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