<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Promotions</h2>

        <a href="{{ route('admin.promotions.create') }}" class="btn btn-success">
            + Create Promotion
        </a>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Search..." wire:model.debounce.500ms="search">
        </div>

        <div class="col-md-3">
            <select class="form-control" wire:model="status">
                <option value="all">All</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($promotions as $promo)
                        <tr>
                            <td>{{ $promo->name }}</td>

                            <td>
                                {{ $promo->code ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst(str_replace('_', ' ', $promo->type)) }}
                                </span>
                            </td>

                            <td>
                                @if ($promo->type === 'percentage')
                                    {{ $promo->value }}%
                                @elseif($promo->type === 'fixed')
                                    RM {{ number_format($promo->value, 2) }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{ $promo->usages_count }}
                            </td>

                            <td>
                                <button wire:click="toggleStatus({{ $promo->id }})"
                                    class="btn btn-sm {{ $promo->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $promo->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>

                            <td>
                                <a href="{{ route('admin.promotions.edit', $promo->id) }}"
                                    class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <button wire:click="delete({{ $promo->id }})"
                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                    class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No promotions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $promotions->links() }}
            </div>

        </div>
    </div>

</div>
