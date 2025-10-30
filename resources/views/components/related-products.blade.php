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
                                <a class="product-thumbnail d-block" href="{{ route('singleproductRoute', $item->name) }}">
                                <!-- Badge-->
                                <span class="badge rounded-pill badge-warning">Sale</span>
                                <!-- Wishlist Button-->
                                <a class="wishlist-btn" href="#"><i class="ti ti-heart"></i></a>
                                    <img class="mb-2" src="{{ asset('storage') . '/'. ($item->images[2] ?? '') }}" alt="">
                                    <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                    <ul class="offer-countdown-timer d-flex align-items-center shadow-sm"
                                        data-countdown="2024/12/31 23:59:59">
                                        <li><span class="days">0</span>d</li>
                                        <li><span class="hours">0</span>h</li>
                                        <li><span class="minutes">0</span>m</li>
                                        <li><span class="seconds">0</span>s</li>
                                    </ul>
                                </a>
                                <!-- Product Title --><a class="product-title" href="{{ route('singleproductRoute', $item->name) }}">{{ $item->name }}</a>
                                <!-- Product Price -->
                                <p class="sale-price">{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span></p>
                                <!-- Rating -->
                                <div class="product-rating"><i class="ti ti-star-filled"></i><i
                                        class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i
                                        class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i></div>
                                <!-- Add to Cart --><a class="btn btn-primary btn-sm" href="#"><i
                                        class="ti ti-plus"></i></a>
                            </div>
                        </div>
                    @empty
                    @endforelse


                </div>
            </div>
        </div>
