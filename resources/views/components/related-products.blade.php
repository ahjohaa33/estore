        <div class="related-product-wrapper bg-white py-3 mb-3">
            <div class="container">
                <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
                    <h6>Related Products</h6><a class="btn btn-sm btn-secondary" href="shop-grid.html">View all</a>
                </div>
                <div class="related-product-slide owl-carousel">
                    @forelse ($product as $item)
                        <div class="card product-card bg-gray shadow-none">
                            <div class="card-body">

                                <!-- Thumbnail -->
                                <a class="product-thumbnail d-block"
                                    href="{{ route('singleproductRoute', $item->name) }}">
                                    <!-- Badge-->
                                    <span class="badge rounded-pill badge-warning">Sale</span>
                                    <!-- Wishlist Button-->
                                    <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                                    <img class="mb-2" style="object-fit: cover;"
                                        src="{{ asset('storage') . '/' . ($item->images[2] ?? '') }}" alt="">
                                    <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                    <ul class="offer-countdown-timer d-flex align-items-center shadow-sm"
                                        data-countdown="2024/12/31 23:59:59">
                                        <li><span class="days">0</span>d</li>
                                        <li><span class="hours">0</span>h</li>
                                        <li><span class="minutes">0</span>m</li>
                                        <li><span class="seconds">0</span>s</li>
                                    </ul>
                                </a>
                                <!-- Product Title --><a class="product-title"
                                    href="{{ route('singleproductRoute', $item->name) }}">{{ $item->name }}</a>
                                <!-- Product Price -->
                                <p class="sale-price">{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span>
                                </p>
                                <!-- Rating -->
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
                               
                        <!-- BUTTON WRAPPER -->
                        <div class="d-flex flex-wrap gap-2 mt-3 buttons-wrapper">

                            <!-- Add to Cart -->
                            <a href="#"
                                class="neo-btn outline-cart-btn flex-fill text-center"
                                data-url="{{ route('cart.add') }}"
                                data-product-id="{{ $item->id }}"
                                data-qty="1"
                                data-color="{{ $defaultColor ?? '' }}"
                                data-size="{{ $defaultSize ?? '' }}"
                                aria-label="Add to Cart">
                                Add to Cart
                            </a>

                            <!-- Buy Now -->
                            <a href="#"
                                class="neo-btn buy-now-btn flex-fill text-center"
                                data-url="{{ route('cart.add') }}"
                                data-product-id="{{ $item->id }}"
                                data-qty="1"
                                data-color="{{ $defaultColor ?? '' }}"
                                data-size="{{ $defaultSize ?? '' }}"
                                aria-label="Buy Now">
                                Buy Now
                            </a>

                        </div>
                            </div>
                        </div>
                    @empty
                    @endforelse


                </div>
            </div>
        </div>
