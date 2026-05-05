<div>
   <style>
      .small-radio {
         width: 14px;
         height: 14px;
      }
   </style>
   @if(count($products) || count($programs))
   <!-- checkout-area start -->
   <section class="checkout-area pb-70 pt-100">
      <div class="container container-small">
         <form wire:submit.prevent="saveOrder">
            <div class="row wow fadeInUp" data-wow-delay=".3s">
               <div class="col-lg-6">
                  <div class="checkbox-form">
                     <h3>Billing Details</h3>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="checkout-form-list">
                              <label>Full Name <span class="required">*</span></label>
                              <input type="text" wire:model.defer="order.name" placeholder="">
                              @error('order.name')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="checkout-form-list">
                              <label>Email Address <span class="required">*</span></label>
                              <input type="email" wire:model.defer="order.email" placeholder="">
                              @error('order.email')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="checkout-form-list">
                              <label>Phone <span class="required">*</span></label>
                              <input type="text" wire:model.defer="order.phone" placeholder="Phone">
                              @error('order.phone')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="checkout-form-list">
                              <label>Company Name</label>
                              <input type="text" wire:model.defer="order.company" placeholder="">
                              @error('order.company')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="checkout-form-list">
                              <label>Address <span class="required">*</span></label>
                              <input type="text" wire:model.defer="order.street_address" placeholder="Street address">
                              @error('order.street_address')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="checkout-form-list">
                              <input type="text" wire:model.defer="order.house_name_number" placeholder="Apartment, suite, unit etc. (optional)">
                              @error('order.house_name_number')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        @if(count($products) > 0)
                        <div class="col-md-6">
                           <div class="checkout-form-list">
                              <label>Country</label>
                              <input type="text" wire:model.defer="order.country" readonly>
                              @error('order.country')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                           <div class="checkout-form-list">
                              <label>Town / City <span class="required">*</span></label>
                              <input type="text" wire:model.defer="order.city" placeholder="Town / City">
                              @error('order.city')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        @if(count($products) > 0)
                        <div class="col-md-6">
                           <div class="checkout-form-list">
                              <label>State / County <span class="required">*</span></label>
                              <select wire:change="orderState" wire:model.defer="order.state" type="text" class="form-control form-control-sm @error('children.gender') border border-danger @enderror">
                                 <option value="">Select</option>
                                 @foreach($states as $state)
                                 <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
                                 @endforeach
                              </select>

                              @error('order.state')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                           <div class="checkout-form-list">
                              <label>Postcode / Zip <span class="required">*</span></label>
                              <input type="text" wire:model.defer="order.postal_code" placeholder="Postcode / Zip">
                              @error('order.postal_code')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="your-order mb-30">
                     <h3>Your order</h3>
                     <div class="your-order-table table-responsive">
                        <table>
                           <thead>
                              <tr>
                                 <th class="product-name"><span class="text_green fw-bold">Product</span></th>
                                 <th class="product-total text_green"><span class="text_green fw-bold">Total</span></th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($products as $id => $details)
                              <tr class="cart_item">
                                 <td class="product-name">
                                    {{ $details['name'] }} {{ isset($details['variation']) ? '('.$details['variation'].')':'' }}
                                    <strong class="product-quantity"> × {{ $details['quantity'] }}</strong> <br>
                                    @if($details['is_subscription'])
                                    <small class="text_orange">Subscribing for {{ $details['subscription_months'] }} Month(s)</small>
                                    @endif
                                 </td>
                                 <td class="product-total">
                                    <span class="amount">{{ getCurrency() }}{{ number_format($details['price']*$details['quantity'] , 2) }}</span>
                                 </td>
                              </tr>
                              @endforeach
                              @foreach($programs as $program)
                              <tr class="cart_item">
                                 <td class="product-name">
                                    {{ $program['order']['program_title'] }}
                                    <strong class="product-quantity"> × {{ $program['order']['children_count'] }}</strong>
                                 </td>
                                 <td class="product-total">
                                    <span class="amount">{{ getCurrency() }}{{ number_format($program['order']['net_total'], 2) }}</span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                           <tfoot>
                              <tr class="shipping">
                                 <th>Shipping</th>
                                 <td>
                                    <span class="amount">{{ getCurrency() }}{{ number_format($shippingCharges ,2) }}</span>
                                 </td>
                              </tr>
                              <tr class="cart-subtotal">
                                 <th><span class="text_orange">Cart Subtotal</span></th>
                                 <td><span class="amount"><span class="text_orange">{{ getCurrency() }}{{ number_format($grandSubTotal , 2) }}</span></span></td>
                              </tr>
                              @if($grandDiscount)
                              <tr class="cart-subtotal">
                                 <th>Discount</th>
                                 <td><span class="amount">{{ getCurrency() }}{{ number_format($grandDiscount , 2) }}</span></td>
                              </tr>
                              @endif
                              <!-- <tr class="shipping">
                                 <th>Vat</th>
                                 <td>
                                     <span class="amount">{{ getCurrency() }}{{ $vat }}</span>
                                 </td>
                              </tr> -->
                              <tr class="order-total">
                                 <th><span class="text_orange">Order Total</span></th>
                                 <td>
                                    <strong><span class="amount text_orange">{{ getCurrency() }}{{ number_format($grandTotal, 2) }}</span></strong>
                                 </td>
                              </tr>
                           </tfoot>
                        </table>
                     </div>

                     <div class="payment-method">
                        <!-- <h6 class="payment-method-title">Payment Method</h6> -->
                        <div class="order-button-payment mt-20 d-flex justify-content-left">
                           <!-- <label class="form-check-label d-flex align-items-center gap-2 m-2">
                              <input type="radio" style="width: 20px;" wire:model="payment_method" value="senangpay">
                              SenangPay
                           </label> -->
                           <br>
                               <!-- <label class="form-check-label d-flex align-items-center gap-2 m-2">
                              <input type="radio" style="width: 20px;" wire:model="payment_method" value="ipay88">
                              iPay88
                           </label><br> -->
                        </div>

                        <div class="order-button-payment mt-20">
                           <button type="submit" wire:loading.attr="disabled">
                              Place Order <span wire:loading wire:target="saveOrder" class="spinner-grow spinner-grow-sm"></span>
                           </button>
                        </div>
                        <div wire:loading wire:target="saveOrder" class="text-center text_orange mt-1">
                           <small><span class="spinner-grow spinner-grow-sm"></span> Please wait , we are processing your order</small>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </section>
   <!-- checkout-area end -->
   @else
   <section>
      <div class="bg-light container mb-50 py-4 rounded text-center">
         <h4 class="text_orange">Please add some Products or Programs in the cart to continue!</h4>
         <a href="{{ route('shop') }}" class="btn btn-lg btn-green">Go To Shop</a>
         <a href="{{ route('programs') }}" class="btn btn-lg btn-green">Go To Programs</a>
      </div>
   </section>
   @endif
</div>