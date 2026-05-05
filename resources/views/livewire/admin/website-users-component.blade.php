<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay />
    <div class="card-body pt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-capitalize">users</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined On</th>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d-M-Y h:i a') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100">
                            <div class="alert alert-secondary text-center">No users Data Found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $users->links() }}
        </div>


    </div>
</div>
