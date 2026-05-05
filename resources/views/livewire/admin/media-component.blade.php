<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if ($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">media Details</h2>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-12">
                        <label class="text-capitalize">Status</label>
                        <select wire:model.defer="media.status" type="text"
                            class="form-control @error('media.status') border border-danger @enderror form-select">
                            <option value="1">Active</option>
                            <option value="0">Archived</option>
                        </select>
                        @error('media.status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-md-12">
                        <label class="text-capitalize">title</label>
                        <input wire:model.defer="media.title" type="text"
                            class="form-control @error('media.title') border border-danger @enderror">
                        @error('media.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">link</label>
                        <input wire:model.defer="media.link" type="text"
                            class="form-control @error('media.link') border border-danger @enderror">
                        @error('media.link')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <h3>Thumbnail</h3>
                        <div>
                            @if ($media->image)
                                <div class="theme_img_box">
                                    <img src="{{ asset($media->image) }}" class="" alt=" " />
                                </div>
                            @endif
                        </div>
                        <x-filepond-input wire:model="image" allowImagePreview imagePreviewMaxHeight="200"
                            allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation
                            maxFileSize="1mb" />
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
                <h2 class="text-capitalize">medias</h2>
                <a href="" wire:click.prevent="createOrEdit"
                    class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New media</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>

                    <th>Image</th>
                    <th>Link</th>

                    <th>Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($medias as $media)
                        <tr>
                            <td>{{ $media->id }}</td>
                            <td>{{ $media->title }}</td>
                            <td>
                                @if ($media->status)
                                    <span class="badge badge-success">active</span>
                                @else
                                    <span class="badge badge-danger">archived</span>
                                @endif
                            </td>
                            <td>
                                @if ($media->image)
                                    <img src="{{ asset($media->image) }}" class="" height="30"
                                        alt=" " />
                                @endif
                            </td>
                            <td>{{ $media->link }}</td>

                            <td>{{ $media->created_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <button wire:click.prevent="createOrEdit({{ $media->id }})"
                                    class="btn btn-sm btn-info">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $media->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-secondary text-center">No medias Data Found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $medias->links() }}
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
