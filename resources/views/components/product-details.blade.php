<div class="page-content-wrapper container-desktop">
  <style>
    /* Mobile-first: full width */
.container-desktop{
  width:100%;
  margin:0;
}

/* Optional: make the image slides look good on all sizes */
.product-slide-wrapper .single-product-slide{
  background-size:cover;
  background-position:center;
  /* Keeps a nice ratio for the hero area; adjust as you like */
  aspect-ratio: 16 / 9;
  /* Fallback if your build doesn't support aspect-ratio */
  min-height: 220px;
}

/* Keep review avatars tidy */
.rating-and-review-wrapper .user-thumbnail img{
  width:44px; height:44px; object-fit:cover; border-radius:50%;
}

/* Desktop & up: containerized */
@media (min-width: 992px){
  .container-desktop{
    max-width: 1200px;         /* tweak: 1140/1200/1280 as you prefer */
    margin-left:auto;
    margin-right:auto;
    padding-left:16px;         /* small breathing room */
    padding-right:16px;
  }
  /* Slight polish on slides when constrained */
  .product-slide-wrapper .product-slides{
    border-radius:12px;
    overflow:hidden;
  }
}

/* Make color/size radios wrap nicely on small screens */
.choose-color-radio,
.choose-size-radio{
  gap:12px; flex-wrap:wrap;
}

  </style>
  <div class="product-slide-wrapper">
    <!-- Product Image Carousel -->
    <div class="product-slides owl-carousel">
      @foreach($product->images ?? [] as $image)
        <div class="single-product-slide" style="background-image: url('{{ asset('storage/' . $image) }}')"></div>
      @endforeach
    </div>

    <!-- Optional Video -->
    @if(!empty($product->video_url))
      <a class="video-btn shadow-sm" id="singleProductVideoBtn" href="{{ $product->video_url }}" target="_blank">
        <i class="ti ti-player-play"></i>
      </a>
    @endif
  </div>

 <div class="product-description pb-3">
        <!-- Product Title & Meta Data-->
        <div class="product-title-meta-data bg-white mb-3 py-3">
          <div class="container d-flex justify-content-between rtl-flex-d-row-r">
            <div class="p-title-price">
              <h5 class="mb-1">{{ $product->name }}</h5>
              <p class="sale-price mb-0 lh-1">{{ $product->offer_price }} BDT<span>{{ $product->price }} BDT</span></p>
            </div>
            <div class="p-wishlist-share"><a href="wishlist-grid.html"><i class="ti ti-heart"></i></a></div>
          </div>
          <!-- Ratings-->
          <div class="product-ratings">
            <div class="container d-flex align-items-center justify-content-between rtl-flex-d-row-r">
              <div class="ratings"><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><span class="ps-1">3 ratings</span></div>
              <div class="total-result-of-ratings"><span>5.0</span><span>Very Good                                </span></div>
            </div>
          </div>
        </div>
        <!-- Flash Sale Panel-->
        {{-- <div class="flash-sale-panel bg-white mb-3 py-3">
          <div class="container">
            <!-- Sales Offer Content-->
            <div class="sales-offer-content d-flex align-items-end justify-content-between">
              <!-- Sales End-->
              <div class="sales-end">
                <p class="mb-1 font-weight-bold"><i class="ti ti-bolt-lightning lni-flashing-effect text-danger"></i> Flash sale end in</p>
                <!-- Please use event time this format: YYYY/MM/DD hh:mm:ss-->
                <ul class="sales-end-timer ps-0 d-flex align-items-center" data-countdown="2025/01/01 14:21:37">
                  <li><span class="days">0</span>d</li>
                  <li><span class="hours">0</span>h</li>
                  <li><span class="minutes">0</span>m</li>
                  <li><span class="seconds">0</span>s</li>
                </ul>
              </div>
              <!-- Sales Volume-->
              <div class="sales-volume text-end">
                <p class="mb-1 font-weight-bold">82% Sold Out</p>
                <div class="progress" style="height: 0.375rem;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 82%;" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
        <!-- Selection Panel-->
        <div class="selection-panel bg-white mb-3 py-3">
          <div class="container d-flex align-items-center justify-content-between">
            <!-- Choose Color-->
            <div class="choose-color-wrapper">
              <p class="mb-1 font-weight-bold">Color</p>
              <div class="choose-color-radio d-flex align-items-center">
                @if(!empty($product->color))
                    @foreach($product->color as $index => $item)
                        <div class="form-check mb-0">
                            <input class="form-check-input " 
                                id="colorRadio{{ $index }}" 
                                type="radio" 
                                name="colorRadio" 
                                {{ $loop->first ? 'checked' : '' }}>
                            <label class="form-check-label" for="colorRadio{{ $index }}">{{ $item }}</label>
                        </div>
                    @endforeach
                @endif

               

              </div>
            </div>
            <!-- Choose Size-->
            <div class="choose-size-wrapper text-end">
              <p class="mb-1 font-weight-bold">Size</p>
              <div class="choose-size-radio d-flex align-items-center">
                @if(!empty($product->size))
                    @foreach($product->size as $index => $item)
                        <div class="form-check mb-0">
                            <input class="form-check-input " 
                                id="sizeRadio{{ $index }}" 
                                type="radio" 
                                name="sizeRadio" 
                                {{ $loop->first ? 'checked' : '' }}>
                            <label class="form-check-label" for="sizeRadio{{ $index }}">{{ $item }}</label>
                        </div>
                    @endforeach
                @endif

              </div>
            </div>
          </div>
        </div>
        <!-- Add To Cart-->
        <div class="cart-form-wrapper bg-white mb-3 py-3">
          <div class="container">
            <form class="cart-form" action="#" method="">
              <div class="order-plus-minus d-flex align-items-center">
                <div class="quantity-button-handler">-</div>
                <input class="form-control cart-quantity-input" type="text" step="1" name="quantity" value="3">
                <div class="quantity-button-handler">+</div>
              </div>
              <button class="btn btn-primary ms-3" type="submit">Add To Cart</button>
            </form>
          </div>
        </div>
        <!-- Product Specification-->
        <div class="p-specification bg-white mb-3 py-3">
          <div class="container">
            <h6>Specifications</h6>
            <p>{{ $product->description ?? 'N\A' }}</p>
            <ul class="mb-3 ps-3">
              <li><i class="ti ti-check me-1"></i> 100% Good Reviews</li>
              <li><i class="ti ti-check me-1"></i> 7 Days Returns</li>
              <li> <i class="ti ti-check me-1"></i> Warranty not Aplicable</li>
              <li> <i class="ti ti-check me-1"></i> 100% Brand New Product</li>
            </ul>
            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, eum? Id, culpa? At officia quisquam laudantium nisi mollitia nesciunt, qui porro asperiores cum voluptates placeat similique recusandae in facere quos vitae?</p>
          </div>
        </div>
        <!-- Product Video -->
        <div class="bg-img" style="background-image: url({{ asset('img/product/18.jpg') }})">
          <div class="container">
            <div class="video-cta-content d-flex align-items-center justify-content-center">
              <div class="video-text text-center">
                <h4 class="mb-4">Summer Clothing</h4><a class="btn btn-primary rounded-circle" id="videoButton" href="https://www.youtube.com/watch?v=lFGvqvPh5jI"><i class="ti ti-player-play"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="pb-3"></div>
        <!-- Related Products Slides-->
        <x-related-products :category="$product->category" />
        <!-- Rating & Review Wrapper -->
      <div class="rating-and-review-wrapper bg-white py-3 mb-3 dir-rtl">
        <div class="container">
          <h6>
            Ratings &amp; Reviews
            <small class="text-muted">
              ({{ number_format($product->reviews_avg_rating, 1) }}/5 • {{ $product->reviews_count }} reviews)
            </small>
          </h6>

          @if ($product->reviews->isEmpty())
            <p class="text-muted mb-0">No reviews yet. Be the first to review!</p>
          @else
            <div class="rating-review-content">
              <ul class="ps-0">
                @foreach ($product->reviews as $review)
                  @php
                    $rating = (int) $review->rating;            // 1..5
                    $full   = max(0, min(5, $rating));
                    $empty  = 5 - $full;
                    $name   = $review->user->name ?? 'Anonymous';
                    $avatar = $review->user->avatar ?? 'img/bg-img/7.jpg'; // fallback avatar
                    $date   = \Illuminate\Support\Carbon::parse($review->created_at)->format('d M Y');
                    $photos = $review->images ?? [];            // expects array of URLs
                  @endphp

                  <!-- Single User Review -->
                  <li class="single-user-review d-flex">
                    <div class="user-thumbnail">
                      <img src="{{ $avatar }}" alt="{{ $name }}">
                    </div>

                    <div class="rating-comment">
                      <div class="rating">
                        @for ($i = 0; $i < $full; $i++)
                          <i class="ti ti-star-filled"></i>
                        @endfor
                        @for ($i = 0; $i < $empty; $i++)
                          <i class="ti ti-star"></i>
                        @endfor
                      </div>

                      <p class="comment mb-0">{{ $review->comment }}</p>
                      <span class="name-date">{{ $name }} • {{ $date }}</span>

                      @if (!empty($photos))
                        @foreach ($photos as $img)
                          <a class="review-image mt-2 border rounded" href="{{ $img }}">
                            <img class="rounded-3" src="{{ $img }}" alt="Review photo">
                          </a>
                        @endforeach
                      @endif
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
      </div>

        <!-- Ratings Submit Form-->
        <div class="ratings-submit-form bg-white py-3 dir-rtl">
          <div class="container">
            <h6>Submit A Review</h6>
            <form action="#" method="">
              <div class="stars mb-3">
                <input class="star-1" type="radio" name="star" id="star1">
                <label class="star-1" for="star1"></label>
                <input class="star-2" type="radio" name="star" id="star2">
                <label class="star-2" for="star2"></label>
                <input class="star-3" type="radio" name="star" id="star3">
                <label class="star-3" for="star3"></label>
                <input class="star-4" type="radio" name="star" id="star4">
                <label class="star-4" for="star4"></label>
                <input class="star-5" type="radio" name="star" id="star5">
                <label class="star-5" for="star5"></label><span></span>
              </div>
              <textarea class="form-control mb-3" id="comments" name="comment" cols="30" rows="10" data-max-length="200" placeholder="Write your review..."></textarea>
              <button class="btn btn-primary" type="submit">Save Review</button>
            </form>
          </div>
        </div>
      </div>
</div>
