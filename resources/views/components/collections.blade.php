 <div class="py-3">
     <div class="container">
         <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
             <h6>Categories</h6><a class="btn btn-sm btn-light" href="#">
                 View all<i class="ms-1 ti ti-arrow-right"></i></a>
         </div>

        
         <!-- Collection Slide-->
         <div class="collection-slide owl-carousel">
             @forelse ($result as $item)
                 <!-- Collection Card-->
                
                 <div class="card collection-card"><a href="single-product.html"><img style="height: 170px; object-fit:cover; " src="{{ asset('storage').'/'.$item['category_image']}}" alt=""></a>
                     <div class="collection-title"><span>{{ $item['category'] }}</span><span class="badge bg-danger">{{ $item['count'] }}</span></div>
                 </div>
             @empty
                 <div>No Collections Found.</div>
             @endforelse


         </div>
     </div>
 </div>
