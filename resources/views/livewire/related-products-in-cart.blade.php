<div>
    @if(count($products))
      <h3>Would you like to add some cool products to your cart?</h3>
      <div class="row">
         @foreach ($products as $product)
               <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6">
                  <div class="bd-product bd-product-2 mb-25 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                     <div class="bd-product-thumb-wrapper">
                        <div class="bd-product-thumb bd-product-thumb-active ">
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
                        <div class="bd-product-action-wrapper">
                           
                           
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
                        
                        <div class="bd-product-price">
                           <span>{{ $product->price() }}</span>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
      </div>
    @endif
</div>
