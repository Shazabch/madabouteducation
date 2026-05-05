<div>
    <div class="card card-custom gutter-b example example-compact">
        <x-full-page-loader wire:loading.delay />
        <div class="card-body pt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text_orange">Subscriptions</h2>
            </div>
            <table class="table  table-stripped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Order Id</th>
                        <th>Product</th>
                        <th>Subscribed For</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subscription->user->name }}
                            <br>
                            <small>{{ $subscription->user->email }}</small> 
                        </td>
                        <td>{{ $subscription->order_id }}</td>
                        <td>{{ $subscription->product->title }}</td>
                        <td>{{ $subscription->subscribed_for }} Month(s)</td>
                        <td>{{ $subscription->start_date }}</td>
                        <td>{{ $subscription->end_date }}</td>
                        <td>
                            <span class="badge badge-success">
                                {{ ucFirst($subscription->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
