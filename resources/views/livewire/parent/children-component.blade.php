<div class="bg-light p-4 rounded my-3">
    <x-full-page-loader wire:loading.delay.long />
    <div class="">
        @if ($editableMode)
            <form wire:submit.prevent="save">
                <h3 class="text-capitalize text_green">children Details</h3>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-6">
                        <label class="mb-2 text-capitalize">Full Name of the Children</label>
                        <input wire:model.defer="children.name" type="text"
                            class="form-control form-control-sm @error('children.name') border border-danger @enderror">
                        @error('children.name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label class="mt-2 mb-2">IC/ Passport No:</label>
                        <input wire:model.defer="children.passport_no" type="text"
                            class="form-control form-control-sm @error('children.passport_no') border border-danger @enderror">
                        @error('children.passport_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="mt-2 mb-2">Date of Birth</label>
                        <input wire:model="children.date_of_birth" type="date"
                            class="form-control form-control-sm @error('children.date_of_birth') border border-danger @enderror">
                        @error('children.date_of_birth')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="mb-2 text-capitalize">Age</label>
                        <input wire:model.defer="children.age" type="number"
                            class="form-control form-control-sm @error('children.age') border border-danger @enderror"
                            readonly>
                        @error('children.age')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="mt-2 mb-2">Gender</label>
                        <select wire:model.defer="children.gender" type="text"
                            class="form-control form-control-sm @error('children.gender') border border-danger @enderror">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('children.gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="mt-2 mb-2">Nationality</label>
                        <select wire:model.defer="children.nationality" type="text"
                            class="form-control form-control-sm @error('children.nationality') border border-danger @enderror">
                            <option value="">Select</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->nationality }}">{{ $country->nationality }}</option>
                            @endforeach
                        </select>
                        @error('children.nationality')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="" class="mt-2 mb-2">Name of school attending</label>
                        <input type="text" class="form-control" wire:model.defer="children.name_of_school_attending">
                        @error('children.name_of_school_attending')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="" class="mt-2 mb-2">Current grade in school</label>
                        <input type="text" class="form-control" wire:model.defer="children.current_grade_in_school">
                        @error('children.current_grade_in_school')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="mt-2 mb-2">Guardian 1</label>
                        <select wire:model.defer="children.guardian_id" type="text"
                            class="form-control form-control-sm @error('children.guardian_id') border border-danger @enderror">
                            <option value="">Select</option>
                            @foreach ($guardians as $guardian)
                                <option value="{{ $guardian->id }}">{{ $guardian->name }}</option>
                            @endforeach
                        </select>
                        @error('children.guardian_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="mt-2 mb-2">Guardian 2</label>
                        <select wire:model.defer="children.guardian_id_2" type="text"
                            class="form-control form-control-sm @error('children.guardian_id_2') border border-danger @enderror">
                            <option value="">Select</option>
                            @foreach ($guardians as $guardian)
                                <option value="{{ $guardian->id }}">{{ $guardian->name }}</option>
                            @endforeach
                        </select>
                        @error('children.guardian_id_2')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-md-12 mt-4">
                        <button type="submit" class="btn btn-green font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit"
                            class="btn btn-outline-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>

                </div>
            </form>
        @else
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-capitalize text_green">childrens</h3>
                <a href="" wire:click.prevent="createOrEdit"
                    class="btn btn-orange font-weight-bolder btn-sm my-2 text-capitalize">Add New children</a>
            </div>

            <table class="table table-sm">
                <thead class="text_green border-green">
                    <th class="text_green">#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Guardian 1</th>
                    <th>Guardian 2</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($childrens as $index=>$children)
                        <tr>
                            <td class="text_green">{{ $childrens->firstItem() + $index }}</td>
                            <td>{{ $children->name }}</td>
                            <td>{{ $children->age }}</td>
                            <td>{{ $children->guardian->name }}</td>
                            <td>{{ $children->guardian2->name }}</td>
                            <td>{{ $children->updated_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <button wire:click.prevent="createOrEdit({{ $children->id }})"
                                    class="btn btn-sm btn-green">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $children->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100">
                                <div class="text_orange text-center"><small>No children Data Found</small></div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $childrens->links() }}
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
