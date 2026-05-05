<section>
    @if(count($program->products))
    <div class="container mt-50">
        <div class="row">
            <div class="col-12">
                <h3 class="bd-section-title mb-0 text_orange">Recommended Products Needed for this Program</h3>
            </div>
            @foreach($program->products as $product)
           <div class="col-xl-4 col-lg-6 col-md-6  col-sm-6">
              <div class="bd-product bd-product-2 mb-25 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                 <div class="bd-product-thumb-wrapper">
                    <div class="bd-product-thumb bd-product-thumb-active swiper-container">
                       <div class="swiper-wrapper">
                           @if($product->main_image)
                           <div class="swiper-slide">
                             <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}">
                           </div>
                           @endif
                           @foreach($product->images as $image)
                          <div class="swiper-slide">
                             <img src="{{ asset($image->path) }}" alt="Image not found!">
                          </div>
                          @endforeach
                       </div>
                    </div>
                    {{-- <div class="bd-product-tag">
                       <span class="theme-bg">Sale</span>
                    </div> --}}
                    <div class="bd-product-action-wrapper">
                       <!-- <div class="bd-product-action-item">
                          <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a>
                       </div> -->
                       <div class="bd-product-action-item">
                          <a href="#" wire:click.prevent="$emitTo('parent.cart-component','add','{{$product->id}}')"><i class="fa-regular fa-cart-shopping"></i></a>
                       </div>
                       <div class="bd-product-action-item">
                          <a href="{{ route('shop.detail',$product->slug) }}">
                             <i class="fa-regular fa-eye"></i>
                          </a>
                       </div>
                    </div>
                    <!-- product slider pagination -->
                    <div class="bd-dots-pagination bd-product-thumb-pagination"></div>
                 </div>
                 <div class="bd-product-content">
                    <h4 class="bd-product-title"><a href="{{ route('shop.detail',$product->slug) }}">{{ $product->title }}</a></h4>
                    <div class="bd-product-rating d-none">
                       <a href="#"><i class="fas fa-star"></i></a>
                       <a href="#"><i class="fas fa-star"></i></a>
                       <a href="#"><i class="fas fa-star"></i></a>
                       <a href="#"><i class="fas fa-star"></i></a>
                       <a href="#"><i class="fas fa-star"></i></a>
                    </div>
                    <div class="bd-product-price">
                       <span>{{ $product->price() }}</span>
                    </div>
                 </div>
              </div>
           </div>
           @endforeach

        </div>
    </div>
    @endif
 </section>
