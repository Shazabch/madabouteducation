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

                                {{-- ============================================================
                                     FREE GIFTS ROWS
                                     Uses $freeGifts directly (not $promotionsData['free_gifts'])
                                     so session-persisted gifts from program triggers are included.
                                     ============================================================ --}}
                                @if (!empty($freeGifts))
                                    @foreach ($freeGifts as $gift)
                                        <tr style="background-color: #f0fff4;">
                                            <td>
                                                <span class="badge"
                                                    style="background-color: #28a745; color: #fff; font-size: 1.2rem; padding: 6px 8px; border-radius: 6px;">
                                                    <i class="fa fa-gift"></i>
                                                </span>
                                            </td>
                                            <td class="product-name">
                                                <span class="fw-bold text-success">
                                                    {{ $gift['product_name'] }}
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fa fa-tag"></i> {{ $gift['promotion_name'] }}
                                                </small>
                                            </td>
                                            <td class="product-price">
                                                <span class="text-success fw-bold">FREE</span>
                                            </td>
                                            <td class="product-quantity text-center">
                                                {{ $gift['quantity'] ?? 1 }}
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="text-success fw-bold">
                                                    {{ getCurrency() }}0.00
                                                </span>
                                            </td>
                                            <td class="product-remove">
                                                {{-- Free gifts cannot be manually removed --}}
                                                <i class="fa fa-lock text-muted" title="Auto-applied gift"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

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

                        @if ($promoDiscount > 0)
                            <ul class="mb-30 text-success">
                                <li>Promo Discount
                                    <span>- {{ getCurrency() }}{{ number_format($promoDiscount, 2) }}</span>
                                </li>
                            </ul>
                        @endif

                        {{-- Free Gifts Summary in totals panel --}}
                        @if (!empty($freeGifts))
                            <div class="mb-20 p-2 rounded" style="background-color: #f0fff4; border: 1px solid #c3e6cb;">
                                <p class="mb-1 fw-bold text-success">
                                    <i class="fa fa-gift"></i> Free Gift(s) Included:
                                </p>
                                <ul class="mb-0" style="list-style: none; padding-left: 0;">
                                    @foreach ($freeGifts as $gift)
                                        <li class="text-success" style="font-size: 0.9rem;">
                                            <i class="fa fa-check-circle"></i>
                                            {{ $gift['product_name'] }}
                                            <span class="text-muted" style="font-size: 0.8rem;">
                                                — via {{ $gift['promotion_name'] }}
                                            </span>
                                        </li>
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