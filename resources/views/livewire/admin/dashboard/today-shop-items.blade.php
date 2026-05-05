<div class="card mb-4">
    <div class="card-body">
        <div class="card-title text-success font-weight-bold">Products Sold Today</div>
        @forelse ($item_groups as $group)
        @php
            $item=$group->first();
        @endphp
        @if($item)
        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3"><img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="{{ asset($item->product->main_image) }}" alt="" />
            <div class="flex-grow-1">
                <h5><a href="">{{ $item->name }}</a></h5>
                <p class="m-0 text-small text-muted"></p>
                <p class="text-small m-0"><span class="badge-pill badge-success">Total Sold: <span class="">{{ $group->sum('quantity') }}</span> </span><br>
                    @php
                        $grouped_by_varaition=$group->groupBy('variation');
                    @endphp
                    @foreach ($grouped_by_varaition as $variation => $items)
                        @if($grouped_by_varaition->count()>1 || !empty($variation))
                        <span class="badge-pill badge-light"><b>{{ $variation ? $variation: 'default' }}: </b> <span class="">{{ $items->sum('quantity') }}</span></span>
                        @endif
                    @endforeach
                    {{-- <del class="text-muted">$500</del> --}}
                </p>
            </div>
            <div>
                {{-- <button class="btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm">
                    View
                    details
                </button> --}}
            </div>
        </div>
        @endif
        @empty
        <div class="bg-gray-100 my-4 p-2 rounded text-mute">
            <span>No Items</span>
        </div>
        @endforelse
    </div>
</div>
