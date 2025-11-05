<style>
    .product-carousel .item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        border-radius: 8px;
    }

    .owl-carousel,
    .owl-stage,
    .owl-item {
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
                <div class="col-6 col-md-3">
                    <div class="card product-card">
                        <div class="card-body">


                            <!-- Carousel -->
                            <div class="product-carousel owl-carousel owl-theme mb-2">
                                @if (!empty($item->images))
                                    @foreach ($item->images as $img)
                                        <div class="item">
                                            <!-- Badge--><span class="badge badge-warning custom-badge"><i
                                                    class="ti ti-star-filled"></i></span>
                                            <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                                            <img style="object-fit: cover;"
                                                src="{{ asset('storage/' . ltrim($img, '/')) }}"
                                                alt="{{ $item->name }}">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <img src="{{ asset('default-product.png') }}" alt="No image">
                                    </div>
                                @endif
                            </div>

                            <a class="product-title"
                                href="{{ route('singleproductRoute', $item->name) }}">{{ $item->name }}</a>
                            <p class="sale-price">{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span></p>
                            <div class="d-flex gap-2">
                                <div class="product-rating">
                                    @php
                                        $avg = round($item->reviews_avg_rating ?? 0, 1); // 0–5, one decimal
                                        $full = (int) floor($avg);
                                        $dec = $avg - $full;
                                        // .75+ rounds up to another full star; .25–.74 shows a half
                                        if ($dec >= 0.75) {
                                            $full++;
                                            $half = 0;
                                        } else {
                                            $half = $dec >= 0.25 ? 1 : 0;
                                        }
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

                            <!-- In your product card/list -->
                            <a href="#" class="neo-btn" data-url="{{ route('cart.add') }}"
                                data-product-id="{{ $item->id }}" data-qty="1"
                                data-color="{{ $defaultColor ?? '' }}" data-size="{{ $defaultSize ?? '' }}"
                                aria-label="Buy Now">
                                Buy Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-3">No products found.</div>
            @endforelse
        </div>
    </div>
</div>
