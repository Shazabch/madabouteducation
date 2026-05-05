<div>
    <div>
        <div class="d-flex justify-content-center align-items-center">
            <span wire:loading class="spinner-bubble spinner-bubble-success"></span>
        </div>
    </div>
    <div wire:loading.class="d-none">
        <div>
            <div class="row">
                <!-- ICON BG-->
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center"><i class="i-Financial"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Sales</p>
                                <p class="text-primary text-24 line-height-1 mb-2"> {{ $totalSales }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Orders</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $totalOrders }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Time</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                @if ($order->invoice)
                                    <a href="{{ asset($order->invoice) }}" target="blank"
                                        class="btn btn-sm btn-primary">Invoice</a>
                                @endif
                                <a href="{{ route('admin.shop.order-details',$order->id) }}" class="btn btn-success btn-sm mt-2">Order Details</a>
                            </td>
                            <td>{{ $order->running_id }}</td>
                            <td>{{ getCurrency() }}{{ $order->net_total }}</td>
                            <td>{{ $order->payment_status->description }}
                                {{ $order->paid_at }}
                                {{ $order->transaction_id }}
                            </td>
                            <td>{{ $order->order_status->description }}</td>
                            <td>N: {{ $order->name }} <br>
                                E:{{ $order->email }}<br>P:{{ $order->phone }}<br>C:{{ $order->company }}</td>
                            <td>
                                @foreach ($order->items as $item)
                                <span class="badge badge-dark">{{ $item->name }} | {{ $item->quantity }}x</span>
                                @endforeach
                            </td>
                            <td>{{ $order->created_at }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $orders->links() }}
            </div>


        </div>
    </div>
</div>
