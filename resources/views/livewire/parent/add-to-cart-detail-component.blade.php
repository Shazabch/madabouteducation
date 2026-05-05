<div class="container">
    <div class="row wow fadeInUp" data-wow-delay=".3s">
        <div class="col-lg-6">
            <div class="product-d-img-tab-wrapper mb-60">
                <div class="product-d-img-nav">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if ($selectedVariationImage)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pro-009-tab" data-bs-toggle="tab"
                                    data-bs-target="#pro-009" type="button" role="tab" aria-controls="pro-009"
                                    aria-selected="false">
                                    <img src="{{ asset($selectedVariationImage) }}"
                                        alt="{{ $product->title }} {{ $selectedVariation }}">
                                </button>
                            </li>
                        @else
                            @if ($product->main_image)
                                <li class="nav-item" role="presentation">

                                    <button class="nav-link active" id="pro-0-tab" data-bs-toggle="tab"
                                        data-bs-target="#pro-0" type="button" role="tab" aria-controls="pro-0"
                                        aria-selected="false">
                                        <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}">
                                    </button>
                                </li>
                            @endif
                            @foreach ($product->images as $image)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="prom-{{ $image->id }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#prom-{{ $image->id }}" type="button" role="tab"
                                        aria-controls="prom-{{ $image->id }}" aria-selected="true">
                                        <img src="{{ asset($image->path) }}" alt="{{ $product->title }}">
                                    </button>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="product-d-img-tab">
                    <div class="tab-content" id="productDetailsTab">
                        @if ($selectedVariationImage)
                            <div class="tab-pane fade active show" id="pro-009" role="tabpanel"
                                aria-labelledby="pro-009-tab">
                                <img class="active" src="{{ asset($selectedVariationImage) }}"
                                    alt="{{ $product->title }} {{ $selectedVariation }}">
                            </div>
                        @else
                            @if ($product->main_image)
                                <div class="tab-pane fade active show" id="pro-0" role="tabpanel"
                                    aria-labelledby="pro-0-tab">
                                    <img class="active" src="{{ asset($product->main_image) }}"
                                        alt="{{ $product->title }}">
                                </div>
                            @endif
                            @foreach ($product->images as $image)
                                <div class="tab-pane fade" id="prom-{{ $image->id }}" role="tabpanel"
                                    aria-labelledby="prom-{{ $image->id }}-tab">
                                    <img class="active" src="{{ asset($image->path) }}" alt="{{ $product->title }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="product-side-info mb-60">
                <h4 class="product-name">{{ $product->title }}</h4>
                <div class="product-price">
                    <!-- <span class="price-old">$63.00</span> -->
                    @if(!$product->is_subscription)
                    <span class="price-now">{{ $product->price() }}</span>
                    @endif
                </div>

                <p class="mb-30">
                    {!! $product->short_description !!}
                </p>
                <div class="">
                    {{-- @if(!$product->is_subscription) --}}

                    @if (count($product->variations))
                        <div class="px-2 py-1 theme-bg-6">
                            <p class="my-0 text_orange">Variations:</p>
                            <div class="d-flex justify-content-start">
                                @if (!empty($product->variations))
                                    @foreach ($product->variations as $variation)
                                        <div wire:click.prevent="$set('selectedVariation','{{ $variation->title }}')"
                                            class="{{ $selectedVariation == $variation->title ? 'border-danger' : '' }} rounded-square-thumbnail border me-2 my-2"
                                            style="background-image: url({{ asset($variation->image) }})"></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if(!$selectedVariation)<small class="text-danger">Please select a variation.</small>@endif
                        <p class="my-0 mb-3">Selected Variation:
                            <span class="badge fw-normal rounded-pill theme-bg-2">{{ empty($selectedVariation) ? 'None' : $selectedVariation }}</span></p>
                    {{-- @endif --}}
                    @endif
                </div>
                <div class="product-quantity-cart mb-30">
                    @if(!$product->is_subscription)

                    <div class="product-quantity-form ">
                        <form action="#">
                            <button class="cart-minus" wire:click.prevent="$set('count','{{ $count - 1 }}')">
                                <i class="far fa-minus"></i>
                            </button>

                            <input class="cart-input" type="text" value="{{ $count }}">
                            <button class="cart-plus" wire:click.prevent="$set('count','{{ $count + 1 }}')">
                                <i class="far fa-plus"></i>
                            </button>
                        </form>
                    </div>
                    <button wire:loading.attr="disabled" {{ (count($product->variations) && !$selectedVariation) ? 'disabled':'' }} {{ $count ? '':'disabled' }} wire:click.prevent="AddToCart" class="bd-cart-btn"><i
                        class="fas fa-shopping-basket"></i>Add to Cart</button>
                    @else
                          <div class="d-flex justify-content-between">
                            <h4 for="">Subscribe For :  </h4> <br>
                            <h3 style="color: #fbb710">
                               &nbsp; RM {{ $subscriptionPrice}}
                            </h3>
                          </div>
                            <select wire:model="subscriptionMonths" class="form-control">
                                <option value="0">Select Months</option>
                                <option value="1">1 Month</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months</option>
                            </select>
                            <button wire:loading.attr="disabled" {{ $subscriptionMonths < 1 ? 'disabled':'' }} wire:click.prevent="AddToCart" class="bd-cart-btn"><i
                                    class="fas fa-shopping-basket"></i>Add to Cart</button>
                        @endif

                    @if (!empty($productInCart))
                        <div class="col-12">
                                <button data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"
                                aria-controls="cartCanvas" class="btn btn-sm btn-outline-success">View Cart</button>
                                <button wire:loading.attr="disabled" wire:click.prevent="removeFromCart" class="btn btn-sm btn-outline-danger">Remove From Cart</button>
                        </div>
                    @endif
                </div>
                <div class="product-d-meta sku mb-10">
                    <span>SKU:</span>
                    <span>{{ $product->sku }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="product_info-faq-area pb-0 pt-20 wow fadeInUp" data-wow-delay=".3s">
        <div class="product-details-tab-wrapper">
            <nav class="product-details-nav mb-30">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="pro-info-1-tab" data-bs-toggle="tab" href="#pro-info-1"
                        role="tab" aria-selected="true">Description</a>

                </div>
            </nav>
            <div class="product-details-content mb-30">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="pro-info-1" role="tabpanel">
                        <div class="tabs-wrapper mt-0">
                            <div class="product__details-des">
                                <p>
                                    {!! $product->description !!}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
