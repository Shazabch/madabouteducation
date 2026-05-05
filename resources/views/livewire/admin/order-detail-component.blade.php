<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay />
    <div class="card-body pt-3">
        <div>
            <div class="align-items-center d-flex justify-content-between">
                <h4 class="text_orange">Order Details</h4>
                <div class="align-items-center d-flex justify-content-end">
                    @if (!$order->isPaid())
                        <a href="{{ route('payment.checkout', ['shop', $order->id]) }}" target="_blank"
                            class="btn btn-sm btn-primary">Pay Now</a>
                    @endif
                    @if ($order->invoice)
                        <a href="{{ asset($order->invoice) }}" target="blank"
                            class="btn btn-sm btn-primary">Invoice</a>
                    @endif
                </div>
            </div>
            <div class="">
                <div class="align-items-center d-flex justify-content-between my-2 p-2 rounded theme-bg-11">
                    <p class="mb-0">Order Status: <span
                            class="badge badge-warning">{{ $order->order_status->description }}</span></p>
                    <p class="mb-0">Payment Status: <span
                            class="{{ $order->paymentLabel() }}">{{ $order->payment_status->description }}</span>
                        @if ($order->isPaid())
                            <span class="badge badge-dark">{{ $order->paidAt() }}</span>
                        @endif
                    </p>
                </div>
                <div class="row no-gutters">
                    @if ($order->canChangeStatus())
                        <div class="form-group col-md-6">
                            <select class="form-control form-select" wire:model.defer="order.order_status"
                                {{ $order->canChangeStatus() ? '' : 'disabled' }}>
                                @foreach ($orderStatuses as $status)
                                    <option value="{{ $status }}">{{ $status->description }}</option>
                                @endforeach
                            </select>


                        </div>
                        @error('order.order_status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="col-md-6">
                            <button wire:click.prevent="save" class="btn btn-sm btn-success">Save</button>
                        </div>

                    @endif
                </div>
                <div class="p-2 rounded theme-bg-11">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Billing</h5>
                            <p>Name: {{ $order->name }}</p>
                            <p>Email: {{ $order->email }}</p>
                            <p>Phone: {{ $order->phone }}</p>
                            <p>Company: {{ $order->company }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Address</h5>
                            <p>Address: {{ $order->street_address }}</p>
                            <p>Apartment/Unit: {{ $order->house_name_number }}</p>
                            <p>City/State/Country: {{ $order->city }} / {{ $order->state }} / {{ $order->country }}
                            </p>
                            <p>Zip: {{ $order->postal_code }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-2 rounded theme-bg-11 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text_orange">Order Summary</h4>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }} x {{ getCurrency() }}{{ $item->price }}
                                                <br>
                                                @if($item->is_subscription)
                                                <p>Subscribed for {{$item->subscription_months}} Month(s)</p>
                                            @endif
                                            </td>
                                            <td>{{ getCurrency() }}{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Subtotal</td>
                                        <td>{{ getCurrency() }} {{ $order->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Tax</td>
                                        <td>{{ getCurrency() }} {{ $order->vat }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Shipping Charges</td>
                                        <td>{{ getCurrency() }} {{ $order->shipping_charges }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Discount</td>
                                        <td>{{ getCurrency() }} {{ $order->discount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text_orange">Total</td>
                                        <td class="text_orange">{{ getCurrency() }}{{ $order->net_total }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
