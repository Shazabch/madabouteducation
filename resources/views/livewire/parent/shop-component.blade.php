<div>
   <section class="bd-product-area pt-120 pb-120">
       <div class="container">
           <div class="product-filter-wrapper mb-20 wow fadeInUp" data-wow-delay=".3s">
               <div class="row">
                   <div class="col-lg-6 col-md-6">
                       <div class="items-showing-text mb-15">
                           <span class="items-showing">{{ $products->total() }}</span> Item On List
                       </div>
                   </div>
                   <div class="col-lg-6 col-md-6">
                       <div class="filter-buttons mb-15">
                           <div class="dropdown filter-category-btn">
                               <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   <i class="far fa-list"></i>Sort By
                               </button>
                               <ul class="dropdown-menu">
                                   <li>
                                       <button class="dropdown-item" wire:click="sortProducts('latest')">
                                           Latest
                                       </button>
                                   </li>
                                   <li>
                                       <button class="dropdown-item" wire:click="sortProducts('oldest')">
                                           Oldest
                                       </button>
                                   </li>
                                   <li>
                                       <button class="dropdown-item" wire:click="sortProducts('price_low_to_high')">
                                           Price: Low to High
                                       </button>
                                   </li>
                                   <li>
                                       <button class="dropdown-item" wire:click="sortProducts('price_high_to_low')">
                                           Price: High to Low
                                       </button>
                                   </li>
                               </ul>
                           </div>
                           <div class="v-line">|</div>
                           <div class="dropdown filter-item-btn">
                               <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   Categories<i class="fal fa-angle-down"></i>
                               </button>
                               <ul class="dropdown-menu">
                                   <li>
                                       <button class="dropdown-item" wire:click="filterByCategory('')">
                                           All Categories
                                       </button>
                                   </li>
                                   @foreach($categories as $category)
                                       <li>
                                           <button class="dropdown-item"
                                                   wire:click="filterByCategory('{{ $category->slug }}')"
                                                   @if($selectedCategory === $category->slug) style="background-color: #f8f9fa;" @endif>
                                               {{ $category->name }} ({{ $category->products_count }})
                                           </button>
                                       </li>
                                   @endforeach
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           @if($selectedCategory)
               <div class="mb-4">
                   <div class="d-flex align-items-center">
                       <span class="me-2">Filtered by category:</span>
                       <span class="badge bg-primary">
                      {{ $categories->firstWhere('slug', $selectedCategory)->name }}
                      <button type="button" class="btn-close btn-close-white ms-2"
                              wire:click="filterByCategory('')" style="font-size: 0.5rem;"></button>
                  </span>
                   </div>
               </div>
           @endif

           <div class="row">
               @forelse($products as $product)
                   <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                       <div class="bd-product bd-product-2 mb-25 wow fadeInUp" data-wow-duration="1s"
                            data-wow-delay=".3s">
                           <div class="bd-product-thumb-wrapper">
                               <div class="bd-product-thumb bd-product-thumb-active swiper-container">
                                   <div class="swiper-wrapper">
                                       @if($product->main_image)
                                           <div class="swiper-slide">
                                               <img src="{{ asset($product->main_image) }}"
                                                    alt="{{ $product->title }}">
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
                               <div class="bd-dots-pagination bd-product-thumb-pagination"></div>
                           </div>
                           <div class="bd-product-content">
                               <h4 class="bd-product-title">
                                   <a href="{{ route('shop.detail',$product->slug) }}">{{ $product->title }}</a>
                               </h4>
                               <div class="bd-product-price">
                                   @if(!$product->is_subscription)
                                   <span>{{ $product->price() }}</span> 
                                      @else
                                      @php
                                          $subscription_prices = json_decode($product->subscription_prices);    
                                    @endphp
                                    <div>


                                    </div>
                               <div>
                                <table class="table">
                                    @foreach($subscription_prices as $key => $subscription_price)
                                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 uppercase border-r last:border-r-0">
                                        {{ str_replace("_", " ", $key) }}
                                    </th>
                                @endforeach

                                <tr>
                                    @foreach($subscription_prices as $key => $subscription_price)
                                        <td class="px-4 py-2 text-lg font-bold text-gray-900 border-r last:border-r-0">
                                            <b>MYR </b>{{ number_format($subscription_price, 2) }}
                                        </td>
                                    @endforeach
                                </tr>

                                </table>
                               </div>
                                   @endif

                               </div>
                           </div>
                       </div>
                   </div>
               @empty
                   <div class="col-12">
                       <div class="alert alert-info text-center">
                           No products found.
                       </div>
                   </div>
               @endforelse
           </div>

           @if($products->hasPages())
               <div class="row">
                   <div class="col-12">
                       <div class="bd-pagination pt-20 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                           {{ $products->links() }}
                       </div>
                   </div>
               </div>
           @endif
       </div>
   </section>
</div>
