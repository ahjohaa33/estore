<div>
    <      <!-- Hero Wrapper -->
      <div class="hero-wrapper">
        <div class="container">
          <div class="pt-1">
            <!-- Hero Slides-->
            <div class="hero-slides owl-carousel">
                @foreach ($slides as $item)
                            <!-- Single Hero Slide-->
                    <div class="single-hero-slide" style="background-image: url('{{asset('storage')}}/{{$item->slider_image}}'); background-size:cover; object-fit:content;">
                        <div class="slide-content h-100 d-flex align-items-center">
                        <div class="slide-text">
                            <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">{{$item->slider_title}}</h4>
                            <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">{{$item->slider_description}}</p><a class="btn btn-primary" href="#" data-animation="fadeInUp" data-delay="800ms" data-duration="1000ms">Buy Now</a>
                        </div>
                        </div>
                    </div>
                @endforeach
            

            </div>
          </div>
        </div>
      </div>
</div>