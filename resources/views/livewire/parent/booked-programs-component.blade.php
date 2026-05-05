<div class="table-responsive bg-light container-fluid mb-2 py-3">
    @push('styles')
        <style>
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            .invoice-container {
                width: 100%;
                margin: 0 auto;
                padding: 30px;
                background-color: #fff;
                box-sizing: border-box;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .invoice-container h1 {
                text-align: center;
                font-size: 28px;
                margin-bottom: 20px;
            }

            .invoice-details {
                margin-bottom: 30px;
            }

            .invoice-table table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .invoice-table th,
            .invoice-table td {
                padding: 10px;
                border-bottom: 1px solid #ddd;
            }

            .invoice-table th {
                text-align: left;
                background-color: #f7f7f7;
                font-weight: bold;
            }

            .total-row td {
                font-weight: bold;
            }

            .text-right {
                text-align: right;
            }
        </style>
    @endpush
    <x-full-page-loader wire:loading.delay.long />
    @if ($order != null)
        <div>
            <div class="text-end mb-2">
                <button class="btn btn-orange" wire:loading.attr="disabled" wire:click.prevent="closeOrderDetails">Close
                    <span wire:loading wire:target="closeOrderDetails"
                        class="spinner spinner-border  spinner-border-sm"></span></button>
            </div>

            <div class="invoice-container row">
                <h1>Order Details</h1>
                <div class="invoice-details col-md-6">
                    <h4>Order Information</h4>
                    <table class="table invoice-table">
                        <tr>
                            <th>Program ID</th>
                            <td>{{ $order->program_id }}</td>
                        </tr>
                        <tr>
                            <th>Children Count</th>
                            <td>{{ $order->children_count }}</td>
                        </tr>
                        <tr>
                            <th>Program Title</th>
                            <td>{{ $order->program_title }}</td>
                        </tr>
                        <tr>
                            <th>Sub Total</th>
                            <td>{{ getCurrency() }} {{ $order->sub_total }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{ getCurrency() }}{{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Net Total</th>
                            <td>{{ getCurrency() }}{{ $order->net_total }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>{{ $order->payment_status }}</td>
                        </tr>
                        <tr>
                            <th>Transaction ID</th>
                            <td>{{ $order->transaction_id }}</td>
                        </tr>
                    </table>
                </div>
                <div class="invoice-details col-md-6">
                    <h4>Contact Information</h4>
                    <table class="table invoice-table">
                        <tr>
                            <th>Name</th>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $order->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <td>{{ $order->company }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td>{{ $order->notes }}</td>
                        </tr>
                        <tr>
                            <th>User ID</th>
                            <td>{{ $order->user_id }}</td>
                        </tr>
                    </table>
                </div>
                <div class="text-right">
                    <h4>Total Amount: ${{ $order->net_total }}</h4>
                </div>

            </div>

        </div>
    @else
        <table class="table table-borderless table-sm">
            <thead class="text_green border-green">
                <th class="text_green">#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Children</th>
                <th>Payment</th>
                <th>Booking Time</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($orders as $index=>$order)
                    <tr>
                        <td class="text_green">{{ $loop->iteration }}</td>
                        <td>{{ $order->full_id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->children_count }}</td>
                        <td>
                            {{ getCurrency() }} {{ $order->net_total }}

                            @if ($order->isPaid())
                                <span
                                    class="badge rounded-pill bg-success">{{ $order->payment_status->description }}</span>
                                <br>
                                <span class="badge rounded-pill bg-dark">{{ $order->paid_at }}</span>
                            @else
                                <span
                                    class="badge rounded-pill bg-danger">{{ $order->payment_status->description }}</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d-M-Y h:i a') }}</td>
                        <td>
                            @if ($order->isGeneratedByShopOrder())
                                @if (!$order->isPaid())
                                    <a href="{{ route('payment.checkout', ['shop', $order->shop_order_id]) }}"
                                        target="_blank" class="btn btn-sm btn-orange">Pay Now</a>
                                @endif
                            @else
                                @if (!$order->isPaid())
                                    <a href="{{ route('payment.checkout', ['camp', $order->id]) }}"
                                        class="btn btn-sm btn-green">Pay Now</a>
                                @endif
                            @endif

                            @if ($order->children_details)
                                <!-- Example single danger button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-orange dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Details
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" role="button" wire:loading.attr="disabled"
                                                wire:click.prevent="orderDetails({{ $order->id }})">Program Details
                                                <span wire:loading wire:target="orderDetails({{ $order->id }})"
                                                    class="spinner spinner-border  spinner-border-sm"></span>
                                            </a>
                                        </li>
                                        <li><a href="{{ asset($order->children_details) }}" target="_blank"
                                                class="dropdown-item">Children Details</a></li>

                                        @if ($order->isGeneratedByShopOrder() && $order->parentOrder->invoice)
                                            <li><a href="{{ asset($order->parentOrder->invoice) }}" target="_blank"
                                                    class="dropdown-item">Invoice</a></li>
                                        @elseif ($order->invoice)
                                            <li><a href="{{ asset($order->invoice) }}" target="_blank"
                                                    class="dropdown-item">Invoice</a></li>
                                        @endif


                                    </ul>
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="100">

                            <div class="collapse" id="collapse-details-{{ $order->id }}">
                                <div class="card card-body"></div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100">
                            <div class="text_orange text-center"><small>No booked programs yet :(</small></div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

</div>
