<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if($program)
                <div class="aloign-items-center bg-primary d-flex justify-content-between p-3 rounded mb-4">
                    <div class="">
                        <h3 class="mb=0 text-white">{{ $program->title }}</h3>
                    </div>
                    <div class="">
                        <a href="{{ route('admin.programs') }}" class="btn btn-sm btn-light">Back To Programs</a>
                    </div>
                </div>

                @if($editableMode)
                    <form wire:submit.prevent="save">
                        <h2 class="text-capitalize">timeTable Details</h2>
                        <div class="row gutters-0 mt-3">

                                                <div class="form-group col-md-12">
                                <label class="text-capitalize">title</label>
                                <input wire:model.defer="timeTable.title" type="text" class="form-control @error('timeTable.title') border border-danger @enderror">
                                @error('timeTable.title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <h4>Activities</h4>
                                @forelse ($activities as $index => $activity)
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">Hour</label>
                                        <input type="text" wire:model.defer="activities.{{ $index }}.hour" class="form-control form-control-sm">
                                        @error('activities.'.$index.'.hour')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Activity</label>
                                        <input type="text" wire:model.defer="activities.{{ $index }}.activity" class="form-control form-control-sm">
                                        @error('activities.'.$index.'.activity')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button type="button" class="btn btn-sm btn-danger mt-4" wire:click="removeActivity({{ $index }})">Remove</button>
                                    </div>
                                </div>
                                @empty
                                <div>
                                    No Activities yet!
                                </div>
                                @endforelse
                                <button type="button" class="btn btn-sm btn-success" wire:click="addActivity">Add New Activity</button>
                            </div>


                            <div class="form-group col-md-12 mt-2">
                                <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                                <button wire:click.prevent="cancelEdit" class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                            </div>

                        </div>
                    </form>
                @else
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-capitalize">timeTables</h2>
                    <a href="" wire:click.prevent="createOrEdit" class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New timeTable</a>
                </div>

                <table class="table table-sm">
                    <thead class="table-light">
                        <th>ID</th>
                        <th>Title</th>
        <th>Activities</th>

                        <th>Time</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @forelse($timeTables as $timeTable)
                        <tr>
                            <td>{{ $timeTable->id }}</td>
                            <td>{{ $timeTable->title }}</td>
                <td>{{ count($timeTable->activities()) }}</td>

                            <td>{{ $timeTable->created_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <button wire:click.prevent="createOrEdit({{ $timeTable->id }})" class="btn btn-sm btn-info">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $timeTable->id }})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-secondary text-center">No timeTables Data Found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $timeTables->links() }}
                </div>
                @endif



        @else
        <div class="p-2">
            <p>Program Not Found</p>
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
