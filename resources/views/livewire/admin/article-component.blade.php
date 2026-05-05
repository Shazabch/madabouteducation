<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if ($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">article Details</h2>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-12">
                        <label class="text-capitalize">Status</label>
                        <select wire:model.defer="article.status" type="text"
                            class="form-control @error('article.status') border border-danger @enderror form-select">
                            <option value="1">Active</option>
                            <option value="0">Archived</option>
                        </select>
                        @error('article.status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>






                    <div class="form-group col-md-12">
                        <label class="text-capitalize">title</label>
                        <input wire:model.lazy="article.title" type="text"
                            class="form-control @error('article.title') border border-danger @enderror">
                        @error('article.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">image</label>
                        <input wire:model.defer="article.image" type="text"
                            class="form-control @error('article.image') border border-danger @enderror">
                        @error('article.image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($article->image)
                        <div class="theme_img_box">
                            <img src="{{ asset($article->image) }}" class="" alt=" " />
                            <button wire:click.prevent="$emit('confirmRemoveMainPhoto')" class="btn btn-danger"><i
                                    class="i-Remove-File"></i></button>
                        </div>
                    @else
                        <div class="col-12">
                            <x-filepond-input wire:model="mainImage" allowImagePreview imagePreviewMaxHeight="200"
                                allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation
                                maxFileSize="1mb" />
                        </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">Meta title</label>
                        <input wire:model.defer="article.meta_title" type="text"
                            class="form-control @error('article.meta_title') border border-danger @enderror">
                        @error('article.meta_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">Meta Description</label>
                        <input wire:model.defer="article.meta_description" type="text"
                            class="form-control @error('article.meta_description') border border-danger @enderror">
                        @error('article.meta_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">slug</label>
                        <input wire:model.defer="article.slug" type="text"
                            class="form-control @error('article.slug') border border-danger @enderror">
                        @error('article.slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="text-capitalize">published On</label>
                        <input wire:model.defer="article.published_on" type="date"
                            class="form-control @error('article.published_on') border border-danger @enderror">
                        @error('article.published_on')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="text-capitalize">content</label>
                        <div wire:ignore>
                            <div class="" x-data x-init="ClassicEditor
                                .create($refs.article_content_box, {
                                    simpleUpload: {
                                        // The URL that the images are uploaded to.
                                        uploadUrl: '{{ route('image.upload') . '?_token=' . csrf_token() }}',
                                    }
                                })
                                .then(editor => {
                                    editor.model.document.on('change:data', () => {
                                        @this.set('article.content', editor.getData(), true);
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });" wire:ignore
                                wire:key="article_content_box" x-ref="article_content_box">{!! $article->content !!}</div>
                        </div>
                        @error('article.content')
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
                <h2 class="text-capitalize">articles</h2>
                <a href="" wire:click.prevent="createOrEdit"
                    class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New article</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>

                    <th>Image</th>
                    <th>Meta_Title</th>
                    <th>Meta_Description</th>
                    <th>Slug</th>
                    <th>Published_On</th>
                    <th>By User</th>

                    <th>Created At</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>
                                @if ($article->status)
                                    <span class="badge badge-success">active</span>
                                @else
                                    <span class="badge badge-danger">archived</span>
                                @endif
                            </td>
                            <td>
                                @if ($article->image)
                                    <img src="{{ asset($article->image) }}" height="30" width="30"
                                        alt="">
                                @endif
                            </td>
                            <td>{{ $article->meta_title }}</td>
                            <td>{{ $article->meta_description }}</td>
                            <td>{{ $article->slug }}</td>
                            <td>{{ $article->published_on }}</td>
                            <td>{{ $article->user->name }}</td>

                            <td>{{ $article->created_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <button wire:click.prevent="createOrEdit({{ $article->id }})"
                                    class="btn btn-sm btn-info">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $article->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-secondary text-center">No articles Data Found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $articles->links() }}
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

        })
    </script>
</div>
