<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if ($editableMode)
            <form wire:submit.prevent="save">
                <div class="align-items-center d-flex justify-content-between mt-2">
                    <h2 class="text-capitalize">program Details</h2>
                    <div class="">
                        <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit"
                            class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>
                </div>
                <div class="row gutters-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Category</label>
                                <select wire:model.defer="program.category_id" type="text"
                                    class="form-control @error('program.category_id') border border-danger @enderror form-select">
                                    <option value="">Select Catgeory</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('program.category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Status</label>
                                <select wire:model.defer="program.status" type="text"
                                    class="form-control @error('program.status') border border-danger @enderror form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Archived</option>
                                </select>
                                @error('program.status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class="text-capitalize">title</label>
                                <input wire:model.lazy="program.title" type="text"
                                    class="form-control @error('program.title') border border-danger @enderror">
                                @error('program.title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">slug</label>
                                <input wire:model.defer="program.slug" type="text"
                                    class="form-control @error('program.slug') border border-danger @enderror">
                                @error('program.slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Short Desc</label>
                                <textarea wire:model.defer="program.short_desc" type="text"
                                    class="form-control @error('program.short_desc') border border-danger @enderror" cols="30" rows="3"></textarea>
                                @error('program.short_desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">venue</label>
                                <input wire:model.defer="program.venue" type="text"
                                    class="form-control @error('program.venue') border border-danger @enderror">
                                @error('program.venue')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">pick_and_drop</label>
                                <input wire:model.defer="program.pick_and_drop" type="text"
                                    class="form-control @error('program.pick_and_drop') border border-danger @enderror">
                                @error('program.pick_and_drop')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- <div class="form-group col-md-6">
                                <label class="text-capitalize">Total Slots</label>
                                <input wire:model.defer="program.total_slots" type="text"
                                    class="form-control @error('program.total_slots') border border-danger @enderror">
                                @error('program.total_slots')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Booked Slots</label>
                                <input wire:model.defer="program.booked_slots" type="text"
                                    class="form-control @error('program.booked_slots') border border-danger @enderror">
                                @error('program.booked_slots')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> -->
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">overview</label>
                                <div wire:ignore>
                                    <div class="" x-data x-init="ClassicEditor
                                        .create($refs.program_overview_box, {
                                            simpleUpload: {
                                                // The URL that the images are uploaded to.
                                                uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                            }
                                        })
                                        .then(editor => {
                                            editor.model.document.on('change:data', () => {
                                                @this.set('program.overview', editor.getData(), true);
                                            })
                                        })
                                        .catch(error => {
                                            console.error(error);
                                        });" wire:ignore
                                        wire:key="program_overview_box" x-ref="program_overview_box">
                                        {!! $program->overview !!}</div>
                                </div>
                                @error('program.overview')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="bg-gray-100 col-md-12 form-group mx-3 py-2 rounded">
                                <h5 class="font-weight-500 text-warning">SST (services sales tax)</h5>
                                <div class="form-check form-check-inline">
                                    <label class="checkbox checkbox-warning">
                                        <input type="checkbox" wire:model.defer="program.is_sst_applicable" value="1" id="check-sst" /><span>Is <b>SST</b> applicable?</span><span class="checkmark"></span>
                                    </label>
                                </div>
                                <h5 class="font-weight-500 mt-3 text-warning">Please Select Type</h5>
                                <select class="form-control" wire:model="program.type">
                                    <option value="">Select</option>
                                    <option value="mom">Mummy or me</option>
                                    <option value="dom">Daddy or me</option>
                                    <option value="sevent">Special Event</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <h5 class="text-primary">Select Form</h5>
                                <select wire:model="program.form_id" type="text"
                                    class="form-control @error('program.form_id') border border-danger @enderror form-select">
                                    <option value="">Select Form</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}">{{ $form->title }}</option>
                                    @endforeach
                                </select>
                                @error('program.category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if ($program->form_id)
                                <div class="col-12 mb-2">
                                    <div class="accordion" id="accordionRightIcon">
                                        <div class="card">
                                            <div class="card-header header-elements-inline">
                                                <h6
                                                    class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                    <a class="text-default collapsed" data-toggle="collapse"
                                                        href="#accordion-form-questions" aria-expanded="false">View
                                                        Form Questions</a></h6>
                                            </div>
                                            <div class="collapse" id="accordion-form-questions"
                                                data-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    @forelse($program->form->getQuestions() as $q)
                                                        <div>
                                                            <p class="bg-gray-100 p-1"><span>{{ $loop->iteration }}-
                                                                </span><span
                                                                    class="text-success"><b>{{ $q['title'] }}</b>
                                                                    <small>
                                                                        @if ($q['is_heading'])
                                                                            (heading)
                                                                        @endif
                                                                    </small>
                                                                </span>
                                                                @if ($q['required'])
                                                                    <small class="text-danger">*</small>
                                                                @endif
                                                                <br><small class="">{{ $q['answer_type'] }}
                                                                    {{ $q['options'] }}</small>
                                                            </p>
                                                        </div>
                                                    @empty
                                                        <p>No Questions found in the form!</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group col-md-12">
                                <h5 class="text-primary">Metas</h5>
                                <label class="text-capitalize">Meta Title</label>
                                <input wire:model.defer="program.meta_title" type="text"
                                    class="form-control @error('program.meta_title') border border-danger @enderror">
                                @error('program.meta_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Meta Description</label>
                                <input wire:model.defer="program.meta_description" type="text"
                                    class="form-control @error('program.meta_description') border border-danger @enderror">
                                @error('program.meta_description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Meta Keywords <small class="text-danger">( Please add comma seperated keywords )</small></label>
                                <input wire:model.defer="program.meta_keywords" type="text"
                                    class="form-control @error('program.meta_keywords') border border-danger @enderror">
                                @error('program.meta_keywords')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 mt-2">
                                <h5 class="text-primary">Images For Slider</h5>
                                @foreach ($program->images as $image)
                                    <div class="theme_img_box">
                                        <img src="{{ asset($image->path) }}" class="" alt=" " />
                                        <button wire:click.prevent="$emit('confirmRemovePhoto',{{ $image->id }})"
                                            class="btn btn-danger"><i class="i-Remove-File"></i></button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-12">
                                <x-filepond-input wire:model="images" multiple allowImagePreview
                                    imagePreviewMaxHeight="200" allowFileTypeValidation
                                    acceptedFileTypes="['image/*']" allowFileSizeValidation maxFileSize="1mb" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">content</label>
                        <div wire:ignore>
                            <div class="" x-data x-init="ClassicEditor
                                .create($refs.program_content_box, {
                                    simpleUpload: {
                                        // The URL that the images are uploaded to.
                                        uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                    }
                                })
                                .then(editor => {
                                    editor.model.document.on('change:data', () => {
                                        @this.set('program.content', editor.getData(), true);
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });" wire:ignore
                                wire:key="program_content_box" x-ref="program_content_box">{!! $program->content !!}
                            </div>
                        </div>
                        @error('program.content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Activity 1</label>
                        <div wire:ignore>
                            <div class="" x-data x-init="ClassicEditor
                                .create($refs.program_activity_1_box, {
                                    simpleUpload: {
                                        // The URL that the images are uploaded to.
                                        uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                    }
                                })
                                .then(editor => {
                                    editor.model.document.on('change:data', () => {
                                        @this.set('program.activities_1', editor.getData(), true);
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });" wire:ignore
                                wire:key="program_activity_1_box" x-ref="program_activity_1_box">{!! $program->activities_1 !!}
                            </div>
                        </div>
                        @error('program.activities_1')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Activity 2</label>
                        <div wire:ignore>
                            <div class="" x-data x-init="ClassicEditor
                                .create($refs.program_activity_2_box, {
                                    simpleUpload: {
                                        // The URL that the images are uploaded to.
                                        uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                    }
                                })
                                .then(editor => {
                                    editor.model.document.on('change:data', () => {
                                        @this.set('program.activities_2', editor.getData(), true);
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });" wire:ignore
                                wire:key="program_activity_2_box" x-ref="program_activity_2_box">{!! $program->activities_2 !!}
                            </div>
                        </div>
                        @error('program.activities_2')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Activity 3</label>
                        <div wire:ignore>
                            <div class="" x-data x-init="ClassicEditor
                                .create($refs.program_activity_3_box, {
                                    simpleUpload: {
                                        // The URL that the images are uploaded to.
                                        uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                    }
                                })
                                .then(editor => {
                                    editor.model.document.on('change:data', () => {
                                        @this.set('program.activities_3', editor.getData(), true);
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });" wire:ignore
                                wire:key="program_activity_3_box" x-ref="program_activity_3_box">{!! $program->activities_3 !!}
                            </div>
                        </div>
                        @error('program.activities_3')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-capitalize">Activity 4</label>
                        <div wire:ignore>
                            <div class="" x-data x-init="ClassicEditor
                                .create($refs.program_activity_4_box, {
                                    simpleUpload: {
                                        // The URL that the images are uploaded to.
                                        uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                    }
                                })
                                .then(editor => {
                                    editor.model.document.on('change:data', () => {
                                        @this.set('program.activities_4', editor.getData(), true);
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });" wire:ignore
                                wire:key="program_activity_4_box" x-ref="program_activity_4_box">{!! $program->activities_4 !!}
                            </div>
                        </div>
                        @error('program.activities_4')
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
                <h2 class="text-capitalize">programs</h2>
                <a href="" wire:click.prevent="createOrEdit"
                    class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New program</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Slug</th>
                    <th>Form</th>

                    <th>Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                        <tr>
                            <td>{{ $program->id }}</td>
                            <td>{{ $program->title }}</td>
                            <td>{{ $program->category->title }}</td>
                            <td>
                                @if ($program->status)
                                    <span class="badge badge-success">active</span>
                                @else
                                    <span class="badge badge-danger">archived</span>
                                @endif
                            </td>
                            <td>
                                @if(!$program->haveGroups())
                                <small class="text-danger"><a class="btn btn-light btn-sm" href="{{ route('admin.programs-groups', $program->id) }}">Add group</a> to start booking.</small>
                                @endif
                                @foreach ($program->groups as $group)
                                    <small class="badge badge-light">{{ getCurrency().$group->price }} <br></small>
                                @endforeach
                                @if($program->is_sst_applicable)
                                    <small class="badge badge-warning">+ SST</small>
                                @endif
                            </td>
                            <td>
                                @foreach ($program->groups as $group)
                                    <span class="badge badge-secondary">{{ $group->date() }} <br></span>
                                @endforeach
                            </td>
                            <td>{{ $program->venue }}</td>
                            <td>{{ $program->slug }}</td>
                            <td>{{ $program->form->title }}</td>

                            <td>{{ $program->created_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <a href="{{ route('admin.programs-timetables', $program->id) }}"
                                    class="btn btn-sm btn-warning">TimeTable</a>
                                <a href="{{ route('admin.programs-groups', $program->id) }}"
                                    class="btn btn-sm btn-dark">Groups</a>
                                <a href="{{ route('admin.programs-addons', $program->id) }}"
                                    class="btn btn-sm btn-primary">Addons</a>
                                <button wire:click.prevent="createOrEdit({{ $program->id }})"
                                    class="btn btn-sm btn-info">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $program->id }})"
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
            <div>
                {{ $programs->links() }}
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
