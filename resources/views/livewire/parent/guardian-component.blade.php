<div class="bg-light p-4 rounded my-3">
    <x-full-page-loader wire:loading.delay.long />
    <div class="">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h3 class="text-capitalize text_green">guardian Details</h3>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-6">
                        <label class="text-capitalize">name</label>
                        <input wire:model.defer="guardian.name" type="text" class="form-control form-control-sm @error('guardian.name') border border-danger @enderror">
                        @error('guardian.name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Relationship</label>
                        <input wire:model.defer="guardian.relationship" type="text" class="form-control form-control-sm @error('guardian.relationship') border border-danger @enderror">
                        @error('guardian.relationship')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input wire:model.defer="guardian.email" type="text" class="form-control form-control-sm @error('guardian.email') border border-danger @enderror">
                        @error('guardian.email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Contact No</label>
                        <input wire:model.defer="guardian.contact_no" type="text" class="form-control form-control-sm @error('guardian.contact_no') border border-danger @enderror">
                        @error('guardian.contact_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Nationality</label>
                        <select wire:model.defer="guardian.nationality" type="text" class="form-control form-control-sm @error('guardian.nationality') border border-danger @enderror">
                            <option value="">Select</option>
                           @foreach ($countries as $country)
                           <option value="{{ $country->nationality }}">{{ $country->nationality }}</option>
                           @endforeach
                        </select>
                        @error('guardian.nationality')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Residential Address</label>
                        <input wire:model.defer="guardian.residential_address" type="text" class="form-control form-control-sm @error('guardian.residential_address') border border-danger @enderror">
                        @error('guardian.residential_address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 mt-2">
                        <button type="submit" class="btn btn-green font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit" class="btn btn-outline-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>

                </div>
            </form>
        @else
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="text-capitalize text_green">guardians</h3>
            <a href="" wire:click.prevent="createOrEdit" class="btn btn-orange font-weight-bolder btn-sm my-2 text-capitalize">Add New guardian</a>
        </div>

        <table class="table table-sm">
            <thead class="text_green border-green">
                <th class="text_green">#</th>
                <th>Name</th>
                <th>Relationship</th>
                <th>Last Updated</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($guardians as $index=>$guardian)
                <tr>
                    <td class="text_green">{{ $guardians->firstItem() + $index }}</td>
                    <td>{{ $guardian->name }}</td>
                    <td>{{ $guardian->relationship }}</td>
                    <td>{{ $guardian->updated_at->format('d-M-Y h:i a') }}</td>
                    <td>
                        <button wire:click.prevent="createOrEdit({{ $guardian->id }})" class="btn btn-sm btn-green">Edit</button>
                        <button wire:click.prevent="$emit('confirmDelete',{{ $guardian->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100">
                        <div class="text_orange text-center"><small>No guardian Data Found</small></div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $guardians->links() }}
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
