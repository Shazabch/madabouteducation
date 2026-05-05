<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long/>
    <div class="card-body pt-1">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">Category Details</h2>
                <div class="row gutters-0 mt-3">
                    <div class="col-12">
                        <div class="row gutters-0 mt-3">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Status</label>
                                <select wire:model.defer="category.status" type="text"
                                        class="form-control @error('category.status') border border-danger @enderror form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Archived</option>
                                </select>
                                @error('category.status')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Name</label>
                                <input wire:model.lazy="category.name" type="text"
                                       class="form-control @error('category.name') border border-danger @enderror">
                                @error('category.name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Slug</label>
                                <input wire:model.defer="category.slug" type="text"
                                       class="form-control @error('category.slug') border border-danger @enderror">
                                @error('category.slug')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description</label>
                                <textarea wire:model.defer="category.description"
                                          class="form-control @error('category.description') border border-danger @enderror"
                                          rows="4"></textarea>
                                @error('category.description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Image</label> <br>
                                @if($category->image)
                                    <div class="theme_img_box">
                                        <img src="{{ asset($category->image) }}" class="" alt=" " height="100"/>
                                        <button wire:click.prevent="$emit('confirmRemoveCategoryImage')"
                                                class="btn btn-danger"><i class="i-Remove-File"></i></button>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <x-filepond-input wire:model="categoryImage" allowImagePreview
                                                          imagePreviewMaxHeight="200" allowFileTypeValidation
                                                          acceptedFileTypes="['image/*']" allowFileSizeValidation
                                                          maxFileSize="1mb"/>
                                    </div>
                                @endif

                                @error('categoryImage')
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
                <h2 class="text-capitalize">Product Categories</h2>
                <a href="" wire:click.prevent="createOrEdit"
                   class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New Category</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Image</th>
                <th>Status</th>
                <th>Products</th>
                <th>Created</th>
                <th>Last updated</th>
                <th>Action</th>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td><img src="{{ asset($category->getImage()) }}" height="30" width="30" alt=""></td>
                        <td>
                            @if($category->status)
                                <span class="badge badge-success">active</span>
                            @else
                                <span class="badge badge-danger">archived</span>
                            @endif
                        </td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->created_at->format('d-M-Y h:i a') }}</td>
                        <td>{{ $category->updated_at ? $category->updated_at->format('d-M-Y h:i a') : '' }}</td>
                        <td>
                            <button wire:click.prevent="createOrEdit({{ $category->id }})" class="btn btn-sm btn-info">
                                Edit
                            </button>
                            <button wire:click.prevent="$emit('confirmDelete',{{ $category->id }})"
                                    class="btn btn-sm btn-danger">Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100">
                            <div class="alert alert-secondary text-center">No Categories Found</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div>
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @this.
            on('confirmDelete', id => {
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
                        @this.
                        call('delete', id)
                    }
                })
            });

            @this.
            on('confirmRemoveCategoryImage', () => {
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
                        @this.
                        call('removeCategoryImage')
                    }
                })
            });
        })
    </script>
</div>
