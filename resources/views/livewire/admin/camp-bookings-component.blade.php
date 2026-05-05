<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay />
    <div class="card-body pt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-capitalize">Program Bookings</h2>
        </div>

        <div class="bg-gray-200 p-2 rounded">
            <div class="row no-gutters">
                <div class="form-group col-md-2">
                    <label>Start Date</label>
                    <input wire:model.defer="startDate" type="date"
                        class="form-control @error('startDate') border border-danger @enderror">
                    @error('startDate')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label>End Date</label>
                    <input wire:model.defer="endDate" type="date"
                        class="form-control @error('endDate') border border-danger @enderror">
                    @error('endDate')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label>Payment Status</label>
                    <select wire:model.defer="paymentStatus"
                        class="form-control @error('paymentStatus') border border-danger @enderror">
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
                    <label>Filter By Date</label>
                    <select wire:model.defer="filterByColumn"
                        class="form-control @error('filterByColumn') border border-danger @enderror">
                        <option value="created_at">Created At</option>
                        <option value="paid_at">Paid At</option>
                    </select>
                    @error('filterByColumn')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>Camp</label>
                    <x-select2 class="form-control" wire:model="selectedCamp" defer="true"   dataArray="camps" id="select_camp_w"/>
                    @error('selectedCamp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12">
                    <button wire:click.prevent="render" class="btn btn-primary"
                        wire:loading.attr="disabled">Update</button>
                </div>
                <div class="col-12">
                    <p>Showing result between <b>{{ $startDate }}</b> and <b>{{ $endDate }}</b>. These results are based
                        on the <b>{{ $filterByColumn }}</b> date.</p>
                </div>
            </div>
        </div>

        <div class="row gap-2 no-gutters">
            <div class="col-md-4 p-1">
                <div class="bg-gray-200 p-2 rounded text-center">
                    <h4>Total Sales</h4>
                    <p>{{ getCurrency() }}{{ $total }}</p>
                </div>
            </div>
            <div class="col-md-4 p-1">
                <div class="bg-gray-200 p-2 rounded text-center">
                    <h4>Total Orders</h4>
                    <p>{{ $totalOrders }}</p>
                </div>
            </div>
            <div class="col-md-4 p-1">
                <div class="bg-gray-200 p-2 rounded text-center">
                    <h4>Total Children</h4>
                    <p>{{ $totalChildren }}</p>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-4">
                <p class="mb-0">
                    @if($selected)
                    <b>{{ count($selected) }}</b> records Selected
                    @endif
                </p>
            </div>
            <div class="col-md-8 d-flex justify-content-end align-items-center">
                <small class="bg-gray-100 mr-2 p-1 text-13 text-danger">Each block with same colour indicates they are booked in the same order.</small>
                <div>
                    <button class="btn btn-success" wire:click.prevent="downloadInvoices"
                        wire:loading.attr="disabled" {{ $selected ? '':'disabled' }}>Download invoices </button>
                    <small wire:loading wire:target="downloadInvoices" class="">creating zip...</small>
                </div>
                <div>
                    <button class="btn btn-success ml-2" wire:click.prevent="downloadDetails"
                        wire:loading.attr="disabled" {{ $selected ? '':'disabled' }}>Download Children Details </button>
                    <small wire:loading wire:target="downloadDetails" class="">creating zip...</small>
                </div>
            </div>
        </div>

        <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <div class="mb-3 form-check">
                                <input wire:model="selectAll" type="checkbox" class="form-check-input"
                                    id="slected_order_all" />
                                <label class="form-check-label" for="slected_order_all">All</label>
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Sub Total</th>
                        <th>Dicsount</th>
                        <th>Net Total</th>
                        <th>Payment Status</th>
                        <th>Name</th>
                        <th>Camp</th>
                        <th>Children</th>
                        <th>Notes By Customer</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $prevId = null;
                        $firstClass = 'bg-gray-200';
                        $secondClass = '';
                        $prevId = null;
                        $currentClass = $firstClass; // Initial CSS class
                    @endphp
                    @foreach ($orders as $index=>$order)
                    @php
                        $currentId = $order->shop_order_id;
                        if ($currentId !== $prevId && ($currentId !== null && $currentId !== '')) {
                            // Change the class when encountering a new non-empty ID
                            $currentClass = ($currentClass === $firstClass) ? $secondClass : $firstClass;
                        }elseif($currentId === null || $currentId === ''){
                            $currentClass = ($currentClass === $firstClass) ? $secondClass : $firstClass;
                        }
                    @endphp
                    <tr class="{{ $currentClass }}">
                        <td>

                            <div class="mb-3 form-check">
                                <input wire:model="selected" type="checkbox" value="{{ $order->id }}"
                                    class="form-check-input" id="selected_order_{{ $order->id }}" />
                                <label class="form-check-label" for="selected_order_{{ $order->id }}"></label>
                            </div>

                        </td>
                        <td>{{ $order->running_id }}</td>
                        <td>{{ getCurrency() }} {{ $order->sub_total }}</td>
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
                        <td>{{ $order->notes }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>
                            @if ($order->invoice)
                            <a href="{{ asset($order->invoice) }}" target="blank"
                                class="btn btn-sm btn-primary mb-1">Invoice</a>
                            @endif
                            <button href="" wire:loading.attr="disabled" wire:click.prevent="regenrateInvoice('{{ $order->id }}')"
                                class="btn btn-sm btn-info mb-1">Re-generate Invoice</button>

                            <button href="" wire:loading.attr="disabled" wire:click.prevent="regenrateChildDetails('{{ $order->id }}')"
                                class="btn btn-sm btn-info mb-1">Re-generate Child Details</button>

                            @if ($order->children_details)
                            <a href="{{ asset($order->children_details) }}" target="blank"
                                class="btn btn-sm btn-primary mb-1">Children Details</a>
                            @endif
                    </tr>
                    @php
                        $prevId = $currentId;
                    @endphp
                    @endforeach
                </tbody>
            </table>


        </div>
        <div>
            {{ $orders->links() }}
        </div>


    </div>
</div>
