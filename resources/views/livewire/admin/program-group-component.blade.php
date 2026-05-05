<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if ($editableMode)
            <form wire:submit.prevent="save">
                <div class="align-items-center d-flex justify-content-between mt-2">
                    <h2 class="text-capitalize">Group Details</h2>
                    <div class="">
                        <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit"
                            class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>
                </div>
                <div class="row gutters-0 mt-3">


                    <div class="form-group col-md-12">
                        <div class="mb-3 form-check">
                            <input wire:model="group.is_reoccuring" type="checkbox" class="form-check-input"
                                id="check1" />
                            <label class="form-check-label" for="check1">Is this program Re-occcuring?</label>
                        </div>
                        @error('group.is_reoccuring')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">Title</label>
                        <input wire:model.defer="group.title" type="text"
                            class="form-control @error('group.title') border border-danger @enderror">
                        @error('group.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Start date</label>
                        <input wire:model.defer="group.start_date" type="date"
                            class="form-control @error('group.start_date') border border-danger @enderror">
                        @error('group.start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        @if (!$group->is_reoccuring)
                            <label class="text-capitalize">End Date </label>
                            <input wire:model.defer="group.end_date" type="date"
                                class="form-control @error('group.end_date') border border-danger @enderror">
                            @error('group.end_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Time</label>
                        <input wire:model="group.time" type="text"
                            class="form-control @error('group.time') border border-danger @enderror">
                        @error('group.time')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">price</label>
                        <input wire:model.defer="group.price" type="text"
                            class="form-control @error('group.price') border border-danger @enderror">
                        @error('group.price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">age_group</label>
                        <input wire:model.defer="group.age_group" type="text"
                            class="form-control @error('group.age_group') border border-danger @enderror">
                        @error('group.age_group')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">age_group extra info</label>
                        <input wire:model.defer="group.age_group_extra_info" type="text"
                            class="form-control @error('group.age_group_extra_info') border border-danger @enderror">
                        @error('group.age_group_extra_info')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Total Slots</label>
                        <input wire:model.defer="group.total_slots" type="text" class="form-control @error('group.total_slots') border border-danger @enderror">
                        @error('group.total_slots')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Booked Slots</label>
                        <input wire:model.defer="group.booked_slots" type="text" class="form-control @error('group.booked_slots') border border-danger @enderror">
                        @error('group.booked_slots')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit"
                            class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>
                </div>
            </form>
        @else
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-capitalize"> Groups | {{ $program->title }}</h2>
                <a href="" wire:click.prevent="createOrEdit"
                    class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New Group</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Age_Group</th>
                    <th>Price</th>
                    <th>Slots</th>
                    <th>Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->title }}</td>
                            <td>{{ $group->date() }}</td>
                            <td>{{ $group->age_group }}</td>
                            <td>{{ $group->price() }}</td>
                            <td>total: {{ $group->total_slots }} <br>booked: {{ $group->booked_slots }}</td>

                            <td>{{ $group->created_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <button wire:click.prevent="createOrEdit({{ $group->id }})"
                                    class="btn btn-sm btn-info">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $group->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-secondary text-center">No programs Data Found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

            @this.on('confirmRemovePhoto', id => {

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
                        @this.call('removePhoto', id)
                    }
                })

            });

        })
    </script>
</div>
