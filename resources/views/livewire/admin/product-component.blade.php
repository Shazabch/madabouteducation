<div class="card card-custom gutter-b example example-compact">
    <style>
        input[type="checkbox"] {
    width: 15px;
    height: 15px;
    margin-left: 5px;
    accent-color: green; /* Makes the checkbox green */
    cursor: pointer;
}
    </style>
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">product Details</h2>
                <div class="row gutters-0 mt-3">
                  <div class="col-7">
                    <div class="row gutters-0 mt-3">

                        <div class="form-group col-md-12">
                            <label class="text-capitalize">Status</label>
                            <select wire:model.defer="product.status" type="text" class="form-control @error('product.status') border border-danger @enderror form-select">
                                <option value="1">Active</option>
                                <option value="0">Archived</option>
                            </select>
                            @error('product.status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">title</label>
                            <input wire:model.lazy="product.title" type="text" class="form-control @error('product.title') border border-danger @enderror">
                            @error('product.title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">price</label>
                            <input wire:model.defer="product.price" type="number" step=".01" class="form-control @error('product.price') border border-danger @enderror">
                            @error('product.price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">sku</label>
                            <input wire:model.defer="product.sku" type="text" class="form-control @error('product.sku') border border-danger @enderror">
                            @error('product.sku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">short_description</label>
                            <div wire:ignore>
                                <div class="" x-data x-init="
                                    ClassicEditor
                                    .create($refs.product_short_description_box,{
                                        simpleUpload: {
                                            // The URL that the images are uploaded to.
                                            uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                                        }
                                    })
                                    .then(editor => {
                                        editor.model.document.on('change:data', () => {
                                            @this.set('product.short_description', editor.getData(), true);
                                        })
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });
                                " wire:ignore wire:key="product_short_description_box" x-ref="product_short_description_box">{!! $product->short_description !!}</div>
                            </div>
                            @error('product.short_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">description</label>
                            <div wire:ignore>
                                <div class="" x-data x-init="
                                    ClassicEditor
                                    .create($refs.product_short_description_box,{
                                        simpleUpload: {
                                            // The URL that the images are uploaded to.
                                            uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                                        }
                                    })
                                    .then(editor => {
                                        editor.model.document.on('change:data', () => {
                                            @this.set('product.description', editor.getData(), true);
                                        })
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });
                                " wire:ignore wire:key="product_short_description_box" x-ref="product_short_description_box">{!! $product->description !!}</div>
                            </div>
                            @error('product.description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">additional_information</label>
                            <input wire:model.defer="product.additional_information" type="text" class="form-control @error('product.additional_information') border border-danger @enderror">
                            @error('product.additional_information')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">slug</label>
                            <input wire:model.defer="product.slug" type="text" class="form-control @error('product.slug') border border-danger @enderror">
                            @error('product.slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">meta_title</label>
                            <input wire:model.defer="product.meta_title" type="text" class="form-control @error('product.meta_title') border border-danger @enderror">
                            @error('product.meta_title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">meta_description</label>
                            <input wire:model.defer="product.meta_description" type="text" class="form-control @error('product.meta_description') border border-danger @enderror">
                            @error('product.meta_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                         <div class="form-group col-md-12">
                                <label class="text-capitalize">Meta Keywords <small class="text-danger">( Please add comma seperated keywords )</small></label>
                                <input wire:model.defer="product.meta_keywords" type="text"
                                    class="form-control @error('product.meta_keywords') border border-danger @enderror">
                                @error('product.meta_keywords')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                            <button wire:click.prevent="cancelEdit" class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                        </div>

                    </div>
                  </div>
                  <div class="col-5">
                    <div class="row gutters-0 mt-3">
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Does this product support subscription?
                                    <input type="checkbox" wire:model="product.is_subscription" class="form-check-input">
                                </label>

                            </div>

                            @if($product['is_subscription'])
                                <div class="form-group col-md-12">
                                    <label class="text-capitalize">Subscription Price for 1 Month</label>
                                    <input wire:model.defer="subscriptionPrices.1_month" type="number" step=".01"
                                           class="form-control @error('subscriptionPrices.1_month') border border-danger @enderror">
                                    @error('subscriptionPrices.1_month')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="text-capitalize">Subscription Price for 6 Months</label>
                                    <input wire:model.defer="subscriptionPrices.6_months" type="number" step=".01"
                                           class="form-control @error('subscriptionPrices.6_months') border border-danger @enderror">
                                    @error('subscriptionPrices.6_months')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="text-capitalize">Subscription Price for 12 Months</label>
                                    <input wire:model.defer="subscriptionPrices.12_months" type="number" step=".01"
                                           class="form-control @error('subscriptionPrices.12_months') border border-danger @enderror">
                                    @error('subscriptionPrices.12_months')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif

                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">Main Image</label> <br>
                            @if($product->main_image)
                            <div class="theme_img_box">
                                <img src="{{ asset($product->main_image) }}" class="" alt=" " />
                                <button wire:click.prevent="$emit('confirmRemoveMainPhoto')" class="btn btn-danger"><i class="i-Remove-File"></i></button>
                            </div>
                            @else
                            <div class="col-12">
                                <x-filepond-input wire:model="mainImage" allowImagePreview imagePreviewMaxHeight="200" allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation maxFileSize="1mb" />
                            </div>
                            @endif

                            @error('product.mainImage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-capitalize">Additional Images</label>
                            <div class="col-12">
                                @foreach($product->images as $image)
                                <div class="theme_img_box">
                                    <img src="{{ asset($image->path) }}" class="" alt=" " />
                                    <button wire:click.prevent="$emit('confirmRemovePhoto',{{ $image->id }})" class="btn btn-danger"><i class="i-Remove-File"></i></button>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <x-filepond-input wire:model="images" multiple allowImagePreview imagePreviewMaxHeight="200" allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation maxFileSize="1mb" />
                            </div>
                            @error('images')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                  </div>
                </div>
            </form>
        @else
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-capitalize">products</h2>
            <a href="" wire:click.prevent="createOrEdit" class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New product</a>
        </div>

        <table class="table table-sm">
            <thead class="table-light">
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Status</th>
                <th>Sku</th>
                <th>Slug</th>
                <th>Created</th>
                <th>Last updated</th>
                <th>Action</th>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset($product->getMainImage()) }}" height="30" width="30" alt=""></td>
                    <td>{{ $product->title }}</td>
                    <td>
                        @if($product->status)
                        <span class="badge badge-success">active</span>
                        @else
                        <span class="badge badge-danger">archived</span>
                        @endif
                    </td>
                    <td>{{ $product->price() }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->slug }}</td>

                    <td>{{ $product->created_at->format('d-M-Y h:i a') }}</td>
                    <td>{{ $product->updated_at ? $product->updated_at->format('d-M-Y h:i a') : '' }}</td>
                    <td>
                        <a href="{{ route('admin.shop.product-variations',$product->id) }}" class="btn btn-sm btn-success">Variations @if($product->variations_count) ({{ $product->variations_count }}) @endif</a>
                        <button wire:click.prevent="createOrEdit({{ $product->id }})" class="btn btn-sm btn-info">Edit</button>
                        <button wire:click.prevent="$emit('confirmDelete',{{ $product->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100">
                        <div class="alert alert-secondary text-center">No products Data Found</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div>
            {{ $products->links() }}
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


            @this.on('confirmRemoveMainPhoto', fn => {

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
                        @this.call('removeMainPhoto')
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
