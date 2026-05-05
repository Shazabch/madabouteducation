<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay />
    <div class="card-body pt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-capitalize">Orders</h2>
        </div>

        <div class="bg-gray-200 p-2 rounded">
            <div class="row no-gutters">
                <div class="form-group col-md-3">
                    <label>Start Date</label>
                    <input wire:model.defer="startDate" type="date"
                        class="form-control @error('startDate') border border-danger @enderror">
                    @error('startDate')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>End Date</label>
                    <input wire:model.defer="endDate" type="date"
                        class="form-control @error('endDate') border border-danger @enderror">
                    @error('endDate')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label>Payment Status</label>
                    <select wire:model.defer="paymentStatus" class="form-control @error('paymentStatus') border border-danger @enderror">
                        <option value="">All</option>
                      @foreach(App\Enums\PaymentStatus::getInstances() as $status)
                      <option value="{{ $status }}">{{ $status->description }}</option>
                      @endforeach
                    </select>
                    @error('paymentStatus')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label>Order Status</label>
                    <select wire:model.defer="orderStatus" class="form-control @error('orderStatus') border border-danger @enderror">
                        <option value="">All</option>
                      @foreach(App\Enums\OrderStatus::getInstances() as $status)
                      <option value="{{ $status }}">{{ $status->description }}</option>
                      @endforeach
                    </select>
                    @error('paymentStatus')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label>Filter By Date</label>
                    <select wire:model.defer="filterByColumn" class="form-control @error('filterByColumn') border border-danger @enderror">
                      <option value="created_at">Created At</option>
                      <option value="paid_at">Paid At</option>
                    </select>
                    @error('filterByColumn')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-2">
                        <button wire:click.prevent="render" class="btn btn-primary" wire:loading.attr="disabled">Update</button>
                </div>
                <div class="col-12">
                    <p>Showing result between <b>{{ $startDate }}</b> and <b>{{ $endDate }}</b>.  These results are based on the <b>{{ $filterByColumn }}</b> date.</p>
                </div>
            </div>
        </div>

        <div class="row gap-2 no-gutters">
            <div class="col-md-6 p-1">
                <div class="bg-gray-200 p-2 rounded text-center">
                    <h4>Total Sales</h4>
                    <p>{{ getCurrency() }}{{ $total }}</p>
                </div>
            </div>
            <div class="col-md-6 p-1">
                <div class="bg-gray-200 p-2 rounded text-center">
                    <h4>Total Orders</h4>
                    <p>{{ $totalOrders }}</p>
                </div>
            </div>
        </div>

        <div>
            @if($selected)
            <p class="mb-0"><b>{{ count($selected) }}</b> records Selected</p>
            @endif
        </div>

        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            <div class="mb-3 form-check">
                                <input wire:model="selectAll" type="checkbox" class="form-check-input" id="slected_order_all"/>
                                <label class="form-check-label" for="slected_order_all">All</label>
                              </div>
                        </th>
                        <th>Action</th>
                        <th>ID</th>
                        <th>Sub Total</th>
                        <th>Shipping Charges</th>
                        <th>Net Total</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Notes By Customer</th>
                        <th>Products</th>
                        <th>Created At</th>
                        <th>Updated At</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <div class="mb-3 form-check">
                                    <input wire:model="selected" type="checkbox" value="{{ $order->id }}" class="form-check-input" id="selected_order_{{ $order->id }}"/>
                                    <label class="form-check-label" for="selected_order_{{ $order->id }}"></label>
                                  </div>
                            </td>
                            <td>
                                @if ($order->invoice)
                                    <a href="{{ asset($order->invoice) }}" target="blank"
                                        class="btn btn-sm btn-primary">Invoice</a>
                                @endif
                                <a href="{{ route('admin.shop.order-details',$order->id) }}"  class="btn btn-success btn-sm mt-2">Order Details</a>
                                <a wire:click="regenerateInvoice({{ $order->id }})" class="btn btn-info text-white btn-sm mt-2">Re-generate Invoice</a>
                            </td>
                            <td>{{ $order->running_id }}</td>
                            <td>{{ getCurrency() }} {{ $order->sub_total }}</td>
                            <td>{{ getCurrency() }}{{ $order->shipping_charges }}</td>
                            <td>{{ getCurrency() }}{{ $order->net_total }}</td>
                            <td>{{ $order->payment_status->description }}
                                {{ $order->paid_at }}
                                {{ $order->transaction_id }}
                            </td>
                            <td>{{ $order->order_status->description }}</td>
                            <td>N: {{ $order->name }} <br>
                                E:{{ $order->email }}<br>P:{{ $order->phone }}<br>C:{{ $order->company }}</td>
                            <td>{{ $order->house_name_number }} <br>
                                {{ $order->street_address }} <br>
                                {{ $order->postal_code }} <br>
                                {{ $order->city }} <br>
                                {{ $order->state }} <br>
                                {{ $order->country }}</td>
                            <td>{{ $order->order_notes }}</td>
                            <td>
                                @foreach ($order->items as $item)
                                <span class="badge badge-dark">{{ $item->name }} | {{ $item->quantity }}x</span>
                                @endforeach
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
        <div>
            {{ $orders->links() }}
        </div>


    </div>
</div>
