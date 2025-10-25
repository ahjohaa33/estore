      <!-- Product Catagories -->
      <div class="product-catagories-wrapper py-3">
        <div class="container">
          <div class="row g-2 rtl-flex-d-row-r">
            @forelse ($cats as $item)
                 <!-- Catagory Card -->
                <div class="col-3">
                <div class="card catagory-card">
                    <div class="card-body px-2"><a href=""><img src="{{ asset('storage') }}/{{ $item->category_image }}" alt=""><span>{{ $item->name }}</span></a></div>
                </div>
                </div>
            @empty
                 <div class="col-12">
                <div class="card catagory-card">
                    <div class="card-body px-2"><a href=""><img src="https://placehold.co/600x400/orange/white" alt=""><span>No Categories found</span></a></div>
                </div>
                </div>
            @endforelse
          </div>
        </div>
      </div>