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
                        <th>ID</th>
                        <th>Dicsount</th>
                        <th>Net Total</th>
                        <th>Payment Status</th>
                        <th>Name</th>
                        <th>Camp</th>
                        <th>Children</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->running_id }}</td>
                        <td>{{ getCurrency() }} {{ $order->discount }}</td>
                        <td>{{ getCurrency() }} {{ $order->net_total }}</td>
                        <td>{{ $order->payment_status->description }}
                            {{ $order->paid_at }}
                            {{ $order->transaction_id }}
                        </td>
                        <td>N: {{ $order->name }} <br>
                            E:{{ $order->email }}<br>P:{{ $order->phone }}<br>C:{{ $order->company }}</td>
                        <td>{{ $order->program_title }}</td>
                        <td>{{ $order->children_count }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            @if ($order->invoice)
                            <a href="{{ asset($order->invoice) }}" target="blank"
                                class="btn btn-sm btn-primary mb-1">Invoice</a>
                            @endif
                            <button href="" wire:loading.attr="disabled" wire:click.prevent="regenrateInvoice('{{ $order->id }}')"
                                class="btn btn-sm btn-info mb-1">Re-generate Invoice</button>

                            @if ($order->children_details)
                            <a href="{{ asset($order->children_details) }}" target="blank"
                                class="btn btn-sm btn-primary mb-1">Children Details</a>
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

    </div>
</div>
