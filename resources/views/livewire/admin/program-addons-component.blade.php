<div class="card card-custom gutter-b example example-compact" wire:init="getAfterInit">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        <form wire:submit.prevent="save">
            <div class="align-items-center d-flex justify-content-between my-2">
                <h2 class="text-capitalize">Program: {{$program->title ?? 'Not Found'}} <small class="text-primary" wire:loading wire:target="getAfterInit">loading..</small></h2>
                <div>
                    <button class="btn btn-success"  wire:loading.attr="disabled" type="submit">Save</button>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="align-items-center bg-gray-100 d-flex flex-column justify-content-center">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" value="{{$product->id}}" wire:model.defer="selectedProducts" class="custom-control-input" id="p-c-{{ $product->id }}">
                                <label class="custom-control-label" for="p-c-{{ $product->id }}">Add To
                                    Programs</label>
                            </div>
                            <div class="theme_img_box">
                                <img src="{{ asset($product->main_image) }}" class="" alt=" " />
                            </div>
                            <div>
                                <h5 class="mb-0 text-center">{{$product->title}}</h5>
                                <p class="text-center mb-0">{{$product->price()}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 text-right">
                <button class="btn btn-success" wire:loading.attr="disabled" type="submit">Save</button>
            </div>
        </form>
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
