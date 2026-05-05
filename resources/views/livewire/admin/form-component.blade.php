<div class="card card-custom gutter-b example example-compact">
    <x-full-page-loader wire:loading.delay.long />
    <div class="card-body pt-1">
        @if ($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">form Details</h2>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-12">
                        <label class="text-capitalize">title</label>
                        <input wire:model.defer="form.title" type="text"
                            class="form-control @error('form.title') border border-danger @enderror">
                        @error('form.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12">
                        <h4>Questions</h4>
                        @forelse ($questions as $index => $question)
                            <div class="border mb-3 mx-1 p-2 row" style="{{ $question['is_heading'] ? 'background: #00bbae26' : '' }}">
                                <div class="form-group col-md-6">
                                    <label for="">{{ $question['is_heading'] ? 'Heading' : 'Question' }}</label>
                                    <input type="text" wire:model.defer="questions.{{ $index }}.title"
                                        class="form-control form-control-sm">
                                    @error('questions.' . $index . '.title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="">Description</label>
                                    <input type="text" wire:model.defer="questions.{{ $index }}.description"
                                        class="form-control form-control-sm">
                                    @error('questions.' . $index . '.description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger mt-4"
                                        wire:click="removeQuestion({{ $index }})">x</button>
                                </div>
                                @if (!$question['is_heading'])
                                    <div class="form-group col-md-2">
                                        <label for="">Required</label>
                                        <select wire:model.defer="questions.{{ $index }}.required"
                                            class="form-control form-control-sm">
                                            <option value="true">Required</option>
                                            <option value="false">Optional</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="">Answer Type</label>
                                        <select wire:model="questions.{{ $index }}.answer_type"
                                            class="form-control form-control-sm" required>
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        @error('questions.' . $index . 'answer_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    @if (in_array($question['answer_type'], ['options_single', 'options_multiple']))
                                        <div class="form-group col-md-7">
                                            <label for="">Options <small>(comma separated i.e
                                                    yes,no,other)</small></label>
                                            <input wire:model.defer="questions.{{ $index }}.options"
                                                class="form-control form-control-sm">
                                            @error('questions.' . $index . 'options')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @empty
                            <div>
                                No Questions yet!
                            </div>
                        @endforelse
                        <button type="button" class="btn btn-sm btn-success" wire:click="addQuestion">Add New
                            Question</button>
                        <button type="button" class="btn btn-sm btn-success" wire:click="addHeading">Add New
                            Heading</button>
                    </div>


                    <div class="form-group col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit"
                            class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>

                </div>
            </form>
        @else
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-capitalize">forms</h2>
                <a href="" wire:click.prevent="createOrEdit"
                    class="btn btn-primary font-weight-bolder btn-sm my-2 text-capitalize">Add New form</a>
            </div>

            <table class="table table-sm">
                <thead class="table-light">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Questions</th>
                    <th>Used In Programs</th>

                    <th>Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($forms as $form)
                        <tr>
                            <td>{{ $form->id }}</td>
                            <td>{{ $form->title }}</td>
                            <td>{{ count($form->getQuestions()) }}</td>
                            <td>{{ $form->programs->count() }}</td>

                            <td>{{ $form->created_at->format('d-M-Y h:i a') }}</td>
                            <td>
                                <button wire:click.prevent="createOrEdit({{ $form->id }})"
                                    class="btn btn-sm btn-info">Edit</button>
                                <button wire:click.prevent="$emit('confirmDelete',{{ $form->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-secondary text-center">No forms Data Found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $forms->links() }}
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
