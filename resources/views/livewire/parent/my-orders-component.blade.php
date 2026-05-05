<div class="bg-light container-fluid mb-2 py-3">
    @if ($selectedOrder)
        <div>
            <div class="align-items-center d-flex justify-content-between">
                <h4 class="text_orange">Order Details</h4>
                <div class="align-items-center d-flex justify-content-end">
                    @if ($selectedOrder->invoice)
                        <a href="{{ asset($selectedOrder->invoice) }}" target="_blank"
                            class="btn btn-sm btn-dark">Invoice</a>
                    @endif
                    @if (!$selectedOrder->isPaid())
                        <a href="{{ route('payment.checkout', ['shop', $selectedOrder->id]) }}" target="_blank"
                            class="btn btn-sm btn-orange ms-2">Pay Now</a>
                    @endif
                    <button class="btn btn-sm btn-green ms-2" wire:click.prevent="close"
                        wire:loading.attr="disabled">Close
                        <span wire:loading.delay.longer wire:target="close"
                            class="spinner-border spinner-border-sm"></span></button>
                </div>
            </div>
            <div class="">
                <div class="align-items-center d-flex justify-content-between my-2 p-2 rounded theme-bg-11">
                    <p class="mb-0">Order Status: <span
                            class="badge bg_orange">{{ $selectedOrder->order_status->description }}</span></p>
                    <p class="mb-0">Payment Status: <span
                            class="{{ $selectedOrder->paymentLabel() }}">{{ $selectedOrder->payment_status->description }}</span>
                        @if ($selectedOrder->isPaid())
                            <span class="badge bg-dark">{{ $selectedOrder->paidAt() }}</span>
                        @endif
                    </p>
                </div>
                <div class="p-2 rounded theme-bg-11">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Billing</h5>
                            <p>Name: {{ $selectedOrder->name }}</p>
                            <p>Email: {{ $selectedOrder->email }}</p>
                            <p>Phone: {{ $selectedOrder->phone }}</p>
                            <p>Company: {{ $selectedOrder->company }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Address</h5>
                            <p>Address: {{ $selectedOrder->street_address }}</p>
                            <p>Apartment/Unit: {{ $selectedOrder->house_name_number }}</p>
                            <p>City/State/Country: {{ $selectedOrder->city }} / {{ $selectedOrder->state }} /
                                {{ $selectedOrder->country }}</p>
                            <p>Zip: {{ $selectedOrder->postal_code }}</p>
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
                                    @foreach ($selectedOrder->items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }} x {{ getCurrency() }}{{ $item->price }} <br>
                                                @if ($item->is_subscription)
                                                    <p>Subscribed for {{ $item->subscription_months }} Month(s)</p>
                                                @endif
                                            </td>
                                            <td>{{ getCurrency() }}{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($selectedOrder->programOrders as $programOrder)
                                        <tr>
                                            <td>{{ $programOrder->program_title }}</td>
                                            <td>{{ $programOrder->children_count }}</td>
                                            <td>
                                                {{ getCurrency() }}{{ $programOrder->net_total }}
                                                @if ($programOrder->discount)
                                                    <small class="badge bg-dark">Discount:
                                                        {{ getCurrency() }}{{ $programOrder->discount }}</small>
                                                @endif
                                                @if ($programOrder->children_details)
                                                    <!-- Example single danger button -->
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-sm btn-orange dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">

                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" role="button"
                                                                    wire:loading.attr="disabled"
                                                                    wire:click.prevent="orderDetails({{ $programOrder->id }})">Program
                                                                    Details
                                                                    <span wire:loading
                                                                        wire:target="orderDetails({{ $programOrder->id }})"
                                                                        class="spinner spinner-border  spinner-border-sm"></span>
                                                                </a>
                                                            </li>
                                                            <li><a href="{{ asset($programOrder->children_details) }}"
                                                                    target="_blank" class="dropdown-item">Children
                                                                    Details</a></li>

                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="p-2 rounded theme-bg-11 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text_orange">Payment Information</h4>
                            <table class="table table-sm">
                                <tfoot>

                                    @if ($selectedOrder->vat)
                                        <tr>
                                            <td colspan="2">Tax</td>
                                            <td>{{ getCurrency() }} {{ $selectedOrder->vat }}</td>
                                        </tr>
                                    @endif

                                    @if ($selectedOrder->shipping_charges)
                                        <tr>
                                            <td colspan="2">Shipping Charges</td>
                                            <td>{{ getCurrency() }} {{ $selectedOrder->shipping_charges }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2">Subtotal</td>
                                        <td>{{ getCurrency() }} {{ $selectedOrder->grand_sub_total }}</td>
                                    </tr>

                                    @if ($selectedOrder->grand_discount)
                                        <tr>
                                            <td colspan="2">Discount</td>
                                            <td>{{ getCurrency() }} {{ $selectedOrder->grand_discount }}</td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td colspan="2" class="text_orange">Total</td>
                                        <td class="text_orange">
                                            {{ getCurrency() }}{{ $selectedOrder->grand_net_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <p class="mb-0">Payment Status: <span
                                                    class="{{ $selectedOrder->paymentLabel() }}">{{ $selectedOrder->payment_status->description }}</span>
                                                @if ($selectedOrder->isPaid())
                                                    <span class="badge bg-dark">{{ $selectedOrder->paidAt() }}</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <table class="table table-sm">
            <thead>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Total</th>
                <th>Details</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->full_id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ getCurrency() }}{{ $order->grand_net_total }}</td>
                        <td>
                            @if ($order->items->count())
                                Products: {{ $order->items->count() }} <br>
                            @endif
                            @if ($order->programOrders->count())
                                Programs: {{ $order->programOrders->count() }}
                            @endif
                        </td>
                        <td>{{ $order->order_status->description }}</td>
                        <td>
                            <span
                                class="{{ $order->paymentLabel() }}">{{ $order->payment_status->description }}</span>
                            @if ($order->isPaid())
                                <br>
                                <span class="badge bg-dark">{{ $order->paidAt() }}</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-green" wire:click.prevent="orderDetails({{ $order->id }})"
                                wire:loading.attr="disabled">Details <span wire:loading.delay.longer
                                    wire:target="orderDetails({{ $order->id }})"
                                    class="spinner-border spinner-border-sm"></span></button>
                            @if (!$order->isPaid())
                                <a href="{{ route('payment.checkout-ipay', ['shop', $order->id]) }}" target="_blank"
                                    class="btn btn-sm btn-orange">Pay Now</a>
                            @endif
                            @if (!$order->isPaid())
                                <button class="btn btn-danger btn-sm"
                                    wire:click.prevent="$emit('confirmDelete',{{ $order->id }})">
                                    Delete
                                </button>
                            @endif

                            @if ($order->invoice)
                                <a href="{{ asset($order->invoice) }}" target="_blank"
                                    class="btn btn-sm btn-dark">Invoice</a>
                            @endif
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @this.on('confirmDelete', id => {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete', id)
                    }
                })

            });

        })
    </script>
</div>
