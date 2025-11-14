@props([])

<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <div class="back-button me-2">
            <a href="{{ url('/') }}"><i class="ti ti-arrow-left"></i></a>
        </div>
        <div class="page-heading">
            <h6 class="mb-0">
                {{ $currentCategory ? $currentCategory : 'Shop' }}
            </h6>
        </div>
        <div class="filter-option ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaFilterOffcanvas"
            aria-controls="suhaFilterOffcanvas">
            <i class="ti ti-adjustments-horizontal"></i>
        </div>
    </div>
</div>

<!-- Offcanvas Filter (kept as UI) -->
<div class="offcanvas offcanvas-start suha-filter-offcanvas-wrap" tabindex="-1" id="suhaFilterOffcanvas"
    aria-labelledby="suhaFilterOffcanvasLabel">
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="offcanvas-body py-5">
        <div class="container">
            <div class="row">
                <!-- your static filter widgets here -->
                <div class="col-12">
                    <div class="apply-filter-btn"><a class="btn btn-lg btn-success w-100" href="#">Apply
                            Filter</a></div>
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

                        @foreach ($categories as $cat)
                            <a class="shadow-sm {{ $currentCategory == $cat ? 'active' : '' }}"
                                href="{{ request()->fullUrlWithQuery(['category' => $cat]) }}">
                                <img style="height: 20px;" src="{{ asset('storage') . '/' . $cat->category_image }}"
                                    alt="">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-4">
                    <!-- Sorting -->
                    <div class="select-product-catagory">
                        <select class="right small border-0" id="selectProductCatagory" name="selectProductCatagory">
                            <option value="">Sort by</option>
                            <option value="newest" {{ $currentSort == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="popular" {{ $currentSort == 'popular' ? 'selected' : '' }}>Popular</option>
                            <option value="ratings" {{ $currentSort == 'ratings' ? 'selected' : '' }}>Ratings</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3"></div>

            <div class="row g-2 rtl-flex-d-row-r">
                @forelse($products as $item)
                    <div class="col-6 col-md-4">
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
                                <p class="sale-price">{{ $item->offer_price }} BDT<span>{{ $item->price }} BDT</span>
                                </p>

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






                                <!-- BUTTON WRAPPER -->
                                <div class="d-flex flex-wrap gap-2 mt-3 buttons-wrapper">

                                    <!-- Add to Cart -->
                                    <a href="#" class="neo-btn outline-cart-btn flex-fill text-center"
                                        data-url="{{ route('cart.add') }}" data-product-id="{{ $item->id }}"
                                        data-qty="1" data-color="{{ $defaultColor ?? '' }}"
                                        data-size="{{ $defaultSize ?? '' }}" aria-label="Add to Cart">
                                        Add to Cart
                                    </a>

                                    <!-- Buy Now -->
                                    <a href="#" class="neo-btn buy-now-btn flex-fill text-center"
                                        data-url="{{ route('cart.add') }}" data-product-id="{{ $item->id }}"
                                        data-qty="1" data-color="{{ $defaultColor ?? '' }}"
                                        data-size="{{ $defaultSize ?? '' }}" aria-label="Buy Now">
                                        Buy Now
                                    </a>

                                </div>








                                <!-- In your product card/list -->



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
    document.addEventListener('DOMContentLoaded', function() {
        const sel = document.getElementById('selectProductCatagory');
        if (sel) {
            sel.addEventListener('change', function() {
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
