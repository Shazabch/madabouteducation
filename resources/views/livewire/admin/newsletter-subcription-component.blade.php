<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">newsletterSubcription Details</h2>
                <div class="row gutters-0 mt-3">

                                        <div class="form-group col-md-12">
                        <label class="text-capitalize">email</label>
                        <input wire:model.defer="newsletterSubcription.email" type="text" class="form-control @error('newsletterSubcription.email') border border-danger @enderror">
                        @error('newsletterSubcription.email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit" class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>

                </div>
            </form>
        @else
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-capitalize">newsletterSubcriptions</h2>
            <div></div>
            {{-- <a href="" wire:click.prevent="createOrEdit" class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New newsletterSubcription</a> --}}
        </div>

        <table class="table table-sm">
            <thead class="table-light">
                <th>ID</th>
                <th>Email</th>

                <th>Time</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($newsletterSubcriptions as $newsletterSubcription)
                <tr>
                    <td>{{ $newsletterSubcription->id }}</td>
                    <td>{{ $newsletterSubcription->email }}</td>

                    <td>{{ $newsletterSubcription->created_at->format('d-M-Y h:i a') }}</td>
                    {{-- <td>
                        <button wire:click.prevent="createOrEdit({{ $newsletterSubcription->id }})" class="btn btn-sm btn-info">Edit</button>
                        <button wire:click.prevent="$emit('confirmDelete',{{ $newsletterSubcription->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="100">
                        <div class="alert alert-secondary text-center">No newsletterSubcriptions Data Found</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $newsletterSubcriptions->links() }}
        </div>
        @endif


    </div>
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
