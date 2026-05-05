<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long/>
    <div class="card-body pt-1">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">Carousel Image Details</h2>
                <div class="row gutters-0 mt-3">
                    <div class="col-12">
                        <div class="row gutters-0 mt-3">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Status</label>
                                <select wire:model.defer="carousel.status"
                                        class="form-control @error('carousel.status') border border-danger @enderror form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('carousel.status')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Title (Optional)</label>
                                <input wire:model.defer="carousel.title" type="text"
                                       class="form-control @error('carousel.title') border border-danger @enderror">
                                @error('carousel.title')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Order</label>
                                <input wire:model.defer="carousel.order" type="number"
                                       class="form-control @error('carousel.order') border border-danger @enderror">
                                @error('carousel.order')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description (Optional)</label>
                                <textarea wire:model.defer="carousel.description"
                                          class="form-control @error('carousel.description') border border-danger @enderror"
                                          rows="3"></textarea>
                                @error('carousel.description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Image</label> <br>
                                @if($carousel->image && !$image)
                                    <div class="theme_img_box">
                                        <img src="{{ asset($carousel->image) }}" class="" alt=" "
                                             style="max-height: 200px;"/>
                                    </div>
                                @endif
                                <div class="col-12 mt-2">
                                    <x-filepond-input wire:model="image" allowImagePreview imagePreviewMaxHeight="200"
                                                      allowFileTypeValidation acceptedFileTypes="['image/*']"
                                                      allowFileSizeValidation maxFileSize="2mb"/>
                                </div>
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                                <button wire:click.prevent="cancelEdit"
                                        class="btn btn-secondary font-weight-bolder btn-sm">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-capitalize">Carousel Images</h2>
                <a href="" wire:click.prevent="createOrEdit"
                   class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New Image</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Order</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
                </thead>
                <tbody>
                @forelse($carouselImages as $image)
                    <tr>
                        <td>{{ $image->id }}</td>
                        <td><img src="{{ asset($image->getImage()) }}" height="50" alt=""></td>
                        <td>{{ $image->title }}</td>
                        <td>{{ $image->order }}</td>
                        <td>
                            @if($image->status)
                                <span class="badge badge-success">active</span>
                            @else
                                <span class="badge badge-danger">inactive</span>
                            @endif
                        </td>
                        <td>{{ $image->created_at->format('d-M-Y h:i a') }}</td>
                        <td>
                            <button wire:click.prevent="createOrEdit({{ $image->id }})" class="btn btn-sm btn-info">
                                Edit
                            </button>
                            <button wire:click.prevent="$emit('confirmDelete',{{ $image->id }})"
                                    class="btn btn-sm btn-danger">Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100">
                            <div class="alert alert-secondary text-center">No Carousel Images Found</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div>
                {{ $carouselImages->links() }}
            </div>
        @endif
    </div>
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
    });
</script>


