      <!-- Product Catagories -->
      <div class="product-catagories-wrapper py-3">
        <div class="container">
          <div class="row g-2 rtl-flex-d-row-r">
            @foreach ($cats as $item)
                 <!-- Catagory Card -->
                <div class="col-3">
                <div class="card catagory-card">
                    <div class="card-body px-2"><a href=""><img src="{{ asset('storage') }}/{{ $item->category_image }}" alt=""><span>{{ $item->name }}</span></a></div>
                </div>
                </div>
            @endforeach
           

          </div>
        </div>
      </div>