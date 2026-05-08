<div>
    <div class="cart-area">
        <div class="container">
            <h3 class="text_orange">Cart</h3>
            {{-- <button class="btn btn-success" wire:click.prevent="recalculatePrograms" wire:loading.attr="disabled">Recalculate</button>
            <button class="btn btn-info" wire:click.prevent="restore" wire:loading.attr="disabled">restore</button> --}}

            <div class="row wow fadeInUp" data-wow-delay=".3s">
                <div class="col-12">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead class="theme-bg-11">
                                <tr>
                                    <th class="product-thumbnail">Images</th>
                                    <th class="cart-product-name">Product</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $details)
                                    <tr>
                                        <td class="">
                                            <a href="{{ route('shop.detail', $details['slug']) }}"><img height="60px"
                                                    src="{{ asset($details['photo']) }}" alt="img"></a>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('shop.detail', $details['slug']) }}">{{ $details['name'] }}
                                                {{ isset($details['variation']) && $details['variation'] ? '(' . $details['variation'] . ')' : '' }}</a>
                                        </td>
                                        <td class="product-price">
                                            <span
                                                class="amount">{{ getCurrency() }}{{ number_format($details['price'] ?? '0', 2) }}</span>
                                        </td>
                                        <td class="product-quantity text-center">
                                            <div class="product-quantity mt-10 mb-10">
                                                <div class="product-quantity-form">
                                                    @if (!$details['is_subscription'])
                                                        <button class="cart-minus"
                                                            wire:click.prevent="addToCart({{ $details['id'] }},{{ $details['quantity'] }}-1,'{{ $details['variation'] }}')">
                                                            <i class="far fa-minus"></i>
                                                        </button>
                                                        <input class="cart-input" type="text"
                                                            value="{{ $details['quantity'] }}">
                                                        <button class="cart-plus"
                                                            wire:click.prevent="addToCart({{ $details['id'] }},{{ $details['quantity'] }}+1,'{{ $details['variation'] }}')">
                                                            <i class="far fa-plus"></i>
                                                        </button>
                                                    @else
                                                        <input class="cart-input" type="text" disabled
                                                            value="{{ $details['quantity'] }}"> <br>
                                                        <b class="text_orange">Subscribing for
                                                            {{ $details['subscription_months'] }} Month(s)</b>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span
                                                class="amount">{{ getCurrency() }}{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                                        </td>
                                        <td class="product-remove">
                                            <a href="#"
                                                wire:click.prevent="remove({{ $details['id'] }},'{{ $details['variation'] }}')"><i
                                                    class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($cartPrograms as $program)
                                    @php
                                        $thisProgram = \App\Models\Program::find(
                                            $program['bookedProgram']['program_id'],
                                        );
                                    @endphp
                                    <tr>
                                        <td class="">
                                            <img height="60px" src="{{ asset($thisProgram->images->first()->path) }}"
                                                alt="img">
                                        </td>
                                        <td class="product-name">
                                            {{ $program['order']['program_title'] }}
                                        </td>
                                        <td class="product-price">
                                            <span class="amount">{{ getCurrency() }}
                                                {{ number_format($program['order']['unit_price'] ?? '0', 2) }}</span>
                                        </td>
                                        <td class="product-quantity text-center">
                                            <span
                                                class="amount">{{ number_format($program['order']['children_count'] ?? '0', 2) }}</span>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">{{ getCurrency() }}
                                                {{ number_format($program['order']['net_total'] ?? '0', 2) }}

                                            </span>
                                            @if (in_array($thisProgram->type, ['mom', 'dom']))
                                                @php
                                                    $tooltip =
                                                        '1st child: ' .
                                                        getCurrency() .
                                                        number_format($program['order']['unit_price'] ?? 0, 2);
                                                    if (($program['order']['children_count'] ?? 1) > 1) {
                                                        for ($i = 2; $i <= $program['order']['children_count']; $i++) {
                                                            $tooltip .=
                                                                "\n{$i} child: + " .
                                                                getCurrency() .
                                                                number_format(250, 2);
                                                        }
                                                    }
                                                    $tooltip .=
                                                        "\nSST (8%): +" .
                                                        getCurrency() .
                                                        number_format($program['order']['sst'] ?? 0, 2);

                                                @endphp

                                                <i style="cursor: pointer;"
                                                    class="cursor-pointer fa fa-info-circle text-info"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $tooltip }}">
                                                </i>
                                            @endif
                                        </td>
                                        <td class="product-remove">
                                            <a href="#"
                                                wire:click.prevent="removeProgram('{{ $program['cart_id'] }}')"><i
                                                    class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 ml-auto">
                    <div class="cart-page-total">
                        <h2>Cart totals</h2>
                        <ul class="mb-30">
                            <li>Products Subtotal <span>{{ getCurrency() }}{{ number_format($subTotal, 2) }}</span>
                            </li>
                            <li>Products Total <span>{{ getCurrency() }}{{ number_format($total, 2) }}</span></li>
                        </ul>
                        @if ($programsNetTotal)
                            <ul class="mb-30">
                                <li>Programs Subtotal
                                    <span>{{ getCurrency() }}{{ number_format($programsSubTotal, 2) }}</span>
                                </li>
                                <li>Programs Discount
                                    <span>{{ getCurrency() }}{{ number_format($programsDiscount, 2) }}</span>
                                </li>
                                @if ($sst)
                                    <li class="text-warning">SST (8%)
                                        <span>{{ getCurrency() }}{{ number_format($sst, 2) }}</span>
                                    </li>
                                @endif
                                <li>Programs Net Total
                                    <span>{{ getCurrency() }}{{ number_format($programsNetTotal, 2) }}</span>
                                </li>
                            </ul>
                        @endif

                        @if($promoDiscount > 0)
                            <ul class="mb-30 text-success">
                                <li>Promo Discount (-{{ getCurrency() }}{{ number_format($promoDiscount, 2) }})
                                    <span>- {{ getCurrency() }}{{ number_format($promoDiscount, 2) }}</span>
                                </li>
                            </ul>
                        @endif

                        @if(!empty($promotionsData['free_gifts']))
                            <div class="mb-20">
                                <strong>Free Gifts:</strong>
                                <ul>
                                   @foreach($promotionsData['free_gifts'] as $gift)
                                      <li class="text-info"><i class="fa fa-gift"></i> Product ID: {{ $gift['product_id'] }} (Free)</li>
                                   @endforeach
                                </ul>
                            </div>
                        @endif

                        <ul class="mb-30">
                            <li class="theme-bg-11">Grand Total
                                <span>{{ getCurrency() }}{{ number_format($grandTotal, 2) }}</span>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <div class="bd-checkout-btn">
                                <a href="{{ route('shop.checkout_details') }}">Proceed to Checkout</a>
                            </div>
                            <div class="bd-checkout-btn">
                                <a href="" class="ms-3 text_green" data-bs-toggle="offcanvas"
                                    data-bs-target="#cartCanvas" aria-controls="cartCanvas"><i
                                        class="fa-regular fa-times"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-7 ml-auto">
                    <div class="mt-60">
                        @livewire('related-products-in-cart', ['alreadyAddedToCart' => collect($products)->pluck('id')])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
