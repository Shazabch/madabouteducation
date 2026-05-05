<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">Program Category Details</h2>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-12">
                        <label class="text-capitalize">title</label>
                        <input wire:model.lazy="programCategory.title" type="text" class="form-control @error('programCategory.title') border border-danger @enderror">
                        @error('programCategory.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">Short Description</label>
                        <input wire:model.lazy="programCategory.short_desc" type="text" class="form-control @error('programCategory.short_desc') border border-danger @enderror">
                        @error('programCategory.short_desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="" class="text-capitalize">Category Icon</label> <br>
                        @if ($programCategory->icon)
                            <div class="theme_img_box">
                                <img src="{{ asset($programCategory->icon) }}" class="" alt=" " />
                                <!-- <button wire:click.prevent="$emit('confirmRemoveMainPhoto')" class="btn btn-danger"><i
                                        class="fas fa-bucket"></i></button> -->
                            </div>
                        @else
                            <x-filepond-input wire:model="icon" allowImagePreview imagePreviewMaxHeight="200"
                                allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation
                                maxFileSize="1mb" />
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">slug</label>
                        <input wire:model.defer="programCategory.slug" type="text" class="form-control @error('programCategory.slug') border border-danger @enderror">
                        @error('programCategory.slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">meta_title</label>
                        <input wire:model.defer="programCategory.meta_title" type="text" class="form-control @error('programCategory.meta_title') border border-danger @enderror">
                        @error('programCategory.meta_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">meta_description</label>
                        <input wire:model.defer="programCategory.meta_description" type="text" class="form-control @error('programCategory.meta_description') border border-danger @enderror">
                        @error('programCategory.meta_description')
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
            <h2 class="text-capitalize">Program Categories</h2>
            <a href="" wire:click.prevent="createOrEdit" class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New Program Category</a>
        </div>

        <table class="table table-sm">
            <thead class="table-light">
                <th>ID</th>
                <th>Title</th>
                <th>Meta_Title</th>
                <th>Meta_Description</th>
                <th>Slug</th>
                <th>Time</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($programCategorys as $programCategory)
                <tr>
                    <td>{{ $programCategory->id }}</td>
                    <td>{{ $programCategory->title }}</td>
                    <td>{{ $programCategory->meta_title }}</td>
                    <td>{{ $programCategory->meta_description }}</td>
                    <td>{{ $programCategory->slug }}</td>
        
                    <td>{{ $programCategory->created_at->format('d-M-Y h:i a') }}</td>
                    <td>
                        <button wire:click.prevent="createOrEdit({{ $programCategory->id }})" class="btn btn-sm btn-info">Edit</button>
                        <button wire:click.prevent="$emit('confirmDelete',{{ $programCategory->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100">
                        <div class="alert alert-seco,ndary text-center">No programCategorys Data Found</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $programCategorys->links() }}
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