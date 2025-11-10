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

    .btn-hover-wrap {
        position: relative;
        display: inline-block;
        /* so it hugs the button */
    }

    .btn-hover-popup {
        position: absolute;
        top: 50%;
        right: 100%;
        /* put it to the left of the button */
        transform: translateY(-50%);
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 6px 10px;
        border-radius: 6px;
        min-width: 150px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity .15s ease, transform .15s ease;
        z-index: 99;
    }

    .btn-hover-wrap:hover .btn-hover-popup {
        opacity: 1;
        transform: translateY(-50%) translateX(-4px);
        /* tiny nudge toward button */
    }


</style>

<div class="top-products-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Top Products</h6>
            <a class="btn btn-sm btn-light" href="{{ route('shop') }}">
                View all<i class="ms-1 ti ti-arrow-right"></i>
            </a>
        </div>

        <div class="row g-2">
            @forelse($products as $item)
                <div class="col-6 col-md-3">
                    <div class="card product-card">
                        <div class="card-body">


                            <!-- Carousel -->
                            <div class="product-carousel owl-carousel owl-theme mb-2">
                                @if (!empty($item->images))
                                    @foreach ($item->images as $img)
                                        <div class="item">
                                            <span class="badge rounded-pill badge-warning">Sale</span>
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
                                    @for ($i = 0; $i < 3; $i++)
                                        <i class="ti ti-star"></i>
                                    @endfor
                                </div>
                                <small class="text-muted">
                                    ({{ $item->reviews_count }} {{ Str::plural('review', $item->reviews_count) }})
                                </small>
                            </div>






                            <a href="#" class="neo-btn" data-url="{{ route('cart.add') }}"
                                data-product-id="{{ $item->id }}" data-qty="1"
                                data-color="{{ $defaultColor ?? '' }}" data-size="{{ $defaultSize ?? '' }}"
                                aria-label="Buy Now">
                                Buy Now
                            </a>







                            <!-- In your product card/list -->



                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-3">No products found.</div>
            @endforelse
        </div>
    </div>
</div>
