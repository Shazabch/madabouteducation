<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">productVariation Details</h2>
                <div class="row gutters-0 mt-3">

                                        <div class="form-group col-md-12">
                        <label class="text-capitalize">title</label>
                        <input wire:model.defer="productVariation.title" type="text" class="form-control @error('productVariation.title') border border-danger @enderror">
                        @error('productVariation.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">image</label>
                        @if($productVariation->image)
                        <div class="theme_img_box">
                            <img src="{{ asset($productVariation->image) }}" class="" alt=" " />
                        </div>
                        @endif
                        <x-filepond-input wire:model="newImage" allowImagePreview imagePreviewMaxHeight="200" allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation maxFileSize="1mb" />

                        @error('productVariation.newImage')
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
            <h2 class="text-capitalize">productVariations | {{ $product->title }}</h2>
            <div>
                <a href="" wire:click.prevent="createOrEdit" class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New productVariation</a>
            <a href="{{ route('admin.shop.products') }}" class="btn btn-info font-weight-bolder btn-sm my-2 text-capitalize">Back To Products</a>
            </div>
        </div>

        <table class="table table-sm">
            <thead class="table-light">
                <th>ID</th>
                <th>Title</th>
<th>Image</th>

                <th>Time</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($productVariations as $productVariation)
                <tr>
                    <td>{{ $productVariation->id }}</td>
                    <td>{{ $productVariation->title }}</td>
        <td>
            @if ($productVariation->image)
            <img src="{{ asset($productVariation->image) }}" height="30" width="30" alt="">
            @endif
        </td>

                    <td>{{ $productVariation->created_at->format('d-M-Y h:i a') }}</td>
                    <td>
                        <button wire:click.prevent="createOrEdit({{ $productVariation->id }})" class="btn btn-sm btn-info">Edit</button>
                        <button wire:click.prevent="$emit('confirmDelete',{{ $productVariation->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100">
                        <div class="alert alert-secondary text-center">No productVariations Data Found</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $productVariations->links() }}
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
