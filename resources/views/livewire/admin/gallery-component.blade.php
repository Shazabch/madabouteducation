<div>
    <div class="row">
        <div class="col-md-8">
            @forelse($images as $image)
                <div class="theme_img_box">
                    <img src="{{ asset($image) }}" class="" alt=" " />
                    <button class="btn btn-danger" wire:click.prevent="$emit('confirmRemovePhoto','{{ $image }}')" ><i class="fas fa-trash"></i></button>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light text-center">No Images in the gallery Yet!</div>
                </div>
            @endforelse
        </div>
        <div class="col-md-4">
            <label for="" class="font-weight-701 text-15">Upload Images</label><small class="ml-2">jpeg,jpg,png,webp</small>
            <x-filepond-input wire:model="newImages" multiple allowImagePreview imagePreviewMaxHeight="200" allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation maxFileSize="1mb" />
            <div><button wire:click.prevent="saveImages" wire:loading.attr="disabled" class="btn btn-primary">Save Images <span wire:loading wire:target="saveImages" class="bg-white px-1 rounded text-primary">loading...</span></button></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('confirmRemovePhoto', path => {

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
                        @this.call('removePhoto', path)
                    }
                })

            });

        })
    </script>
    
</div>
