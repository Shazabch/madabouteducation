<div>
    @push('styles')
        <style>
            .fs-desc {
                font-size: 12px;
            }
        </style>
    @endpush
    @if ($currentStep == 0)
        <div class="theme-bg-7 p-3 mb-2 mt-3">
            <form wire:submit.prevent="saveChildrenDetails">
                <div class="bg_orange rounded p-2">
                    <h3 class="text-white mb-0">Add Children Detail For Booking</h3>
                </div>

                @forelse($children as $index => $child)
                    <div class="row mb-2">
                        <div class="col-12 my-1">
                            <div class="row justify-content-between align-items-center">
                                <h5 class="text_orange col">Child {{ $loop->iteration }}</h5>
                                <div class="col-md-5 col-7 d-flex">
                                    <select class="form-select form-select-sm"
                                        wire:change.prevent="$emit('fillChild',$event.target.value,{{ $index }})">
                                        <option value="">Prefill Child Info</option>
                                        @foreach ($myChildren as $childIndex => $myChild)
                                            <option value="{{ $childIndex }}">{{ $myChild['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-danger mb-1"
                                        wire:click.prevent="removeChild({{ $index }})">x</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Full Name of the Children</label>
                            <input wire:model.defer="children.{{ $index }}.name" type="text"
                                class="form-control @error('children.name') border border-danger @enderror" required>
                            @error('children.' . $index . '.name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Date of Birth</label>
                            <input wire:model="children.{{ $index }}.date_of_birth" type="date"
                                class="form-control form-control-sm @error('children.' . $index . '.date_of_birth') border border-danger @enderror"
                                required>
                            @error('children.' . $index . '.date_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Age</label>
                            <input wire:model.defer="children.{{ $index }}.age" type="text"
                                class="form-control @error('children.age') border border-danger @enderror" readonly>
                            @error('children.' . $index . '.age')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>IC/ Passport No:</label>
                            <input wire:model.defer="children.{{ $index }}.passport_no" type="text"
                                class="form-control form-control-sm @error('children.passport_no') border border-danger @enderror"
                                required>
                            @error('children.' . $index . '.passport_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>



                        <div class="form-group col-md-6">
                            <label>Gender</label>
                            <select wire:model.defer="children.{{ $index }}.gender" type="text"
                                class="form-control form-control-sm @error('children.' . $index . '.gender') border border-danger @enderror"
                                required>
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('children.' . $index . '.gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nationality</label>
                            <select wire:model.defer="children.{{ $index }}.nationality" type="text"
                                class="form-control form-control-sm @error('children.' . $index . '.nationality') border border-danger @enderror"
                                required>
                                <option value="">Select</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->nationality }}">{{ $country->nationality }}</option>
                                @endforeach
                            </select>
                            @error('children.' . $index . '.nationality')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Name of school attending</label>
                            <input wire:model.defer="children.{{ $index }}.name_of_school_attending"
                                type="text"
                                class="form-control form-control-sm @error('children.' . $index . '.name_of_school_attending') border border-danger @enderror">
                            @error('children.' . $index . '.name_of_school_attending')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Current grade in school</label>
                            <input wire:model.defer="children.{{ $index }}.current_grade_in_school"
                                type="text"
                                class="form-control form-control-sm @error('children.' . $index . '.current_grade_in_school') border border-danger @enderror">
                            @error('children.' . $index . '.current_grade_in_school')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <!-- Guardian Start -->
                    <div class="row mb-2">
                        <div class="col-12 my-1">
                            <div class="row justify-content-between align-items-center">
                                <h5 class="text_orange col">Guardian 1 <small class="text-danger"> (Required)</small>
                                </h5>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input wire:model.defer="guardians.{{ $index }}.name" type="text"
                                class="form-control @error('guardians.name') border border-danger @enderror" required>
                            @error('guardians.' . $index . '.name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Relationship</label>
                            <input wire:model.defer="guardians.{{ $index }}.relationship" type="text"
                                class="form-control @error('guardians.relationship') border border-danger @enderror"
                                required>
                            @error('guardians.' . $index . '.relationship')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input wire:model.defer="guardians.{{ $index }}.email" type="text"
                                class="form-control @error('guardians.email') border border-danger @enderror" required>
                            @error('guardians.' . $index . '.email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Contact No</label>
                            <input wire:model.defer="guardians.{{ $index }}.contact_no" type="text"
                                class="form-control @error('guardians.contact_no') border border-danger @enderror"
                                required>
                            @error('guardians.' . $index . '.contact_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nationality</label>
                            <select wire:model.defer="guardians.{{ $index }}.nationality" type="text"
                                class="form-control form-control-sm @error('guardians.' . $index . '.nationality') border border-danger @enderror">
                                <option value="">Select</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->nationality }}">{{ $country->nationality }}</option>
                                @endforeach
                            </select>
                            @error('guardians.' . $index . '.nationality')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Residential Address</label>
                            <input wire:model.defer="guardians.{{ $index }}.residential_address" type="text"
                                class="form-control @error('guardians.residential_address') border border-danger @enderror"
                                required>
                            @error('guardians.' . $index . '.residential_address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if (!$loop->last)
                            <hr class="mt-4">
                        @endif

                    </div>
                    <!-- Guardian End -->
                    <!-- Guardian 2 Start -->
                    <div class="row mb-2">
                        <div class="col-12 my-1">
                            <div class="row justify-content-between align-items-center">
                                <h5 class="text_orange col">Guardian 2 <small class="text-success"> (optional)</small>
                                </h5>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input wire:model.defer="guardians2.{{ $index }}.name" type="text"
                                class="form-control @error('guardians2.name') border border-danger @enderror">
                            @error('guardians2.' . $index . '.name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Relationship</label>
                            <input wire:model.defer="guardians2.{{ $index }}.relationship" type="text"
                                class="form-control @error('guardians2.relationship') border border-danger @enderror">
                            @error('guardians2.' . $index . '.relationship')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input wire:model.defer="guardians2.{{ $index }}.email" type="text"
                                class="form-control @error('guardians2.email') border border-danger @enderror">
                            @error('guardians2.' . $index . '.email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Contact No</label>
                            <input wire:model.defer="guardians2.{{ $index }}.contact_no" type="text"
                                class="form-control @error('guardians2.contact_no') border border-danger @enderror">
                            @error('guardians2.' . $index . '.contact_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nationality</label>
                            <select wire:model.defer="guardians2.{{ $index }}.nationality" type="text"
                                class="form-control form-control-sm @error('guardians2.' . $index . '.nationality') border border-danger @enderror">
                                <option value="">Select</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->nationality }}">{{ $country->nationality }}</option>
                                @endforeach
                            </select>
                            @error('guardians2.' . $index . '.nationality')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Residential Address</label>
                            <input wire:model.defer="guardians2.{{ $index }}.residential_address"
                                type="text"
                                class="form-control @error('guardians2.residential_address') border border-danger @enderror">
                            @error('guardians2.' . $index . '.residential_address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if (!$loop->last)
                            <hr class="mt-4">
                        @endif

                    </div>
                    <!-- Guardian 2 End -->
                @empty
                    <div class="my-3">
                        <span class="text-center"><small>No Child Added Yet!</small></span>
                    </div>
                @endforelse

                <div class="col-12">
                    <button class="btn btn-green my-2" wire:click.prevent="addChild()"
                        wire:loading.attr="disabled">Add
                        {{ count($this->children) ? ' another ' : '' }} Child <span wire:loading
                            wire:target="addChild" class="spinner-border spinner-border-sm"></span></button>
                    @if (count($this->children))
                        <button type="submit" class="btn btn-orange" wire:loading.attr="disabled">Next <i
                                class="fas fa-chevron-right"></i> <span wire:loading wire:target="saveChildrenDetails"
                                class="spinner spinner-border  spinner-border-sm"></span></button>
                    @endif
                </div>
                <div>

                </div>

            </form>
        </div>
    @elseif($currentStep == 1)
        <div class="theme-bg-7 p-3 mb-2">
            <form wire:submit.prevent="saveQuestions">
                <div class="row">
                    <div class="bg_orange rounded p-2">
                        <h3 class="mb-0 text-white">Fill Information For Child
                            {{ $children[$currentQuestionsIndex]['name'] }}</h3>
                    </div>
                    <h3 class="text_orange mb-0">Questions</h3>
                    <small>Please answer the below questions to continue.</small>
                    <br><br>
                    @foreach ($questions as $index => $question)
                        @if ($question['is_heading'])
                            <div class="mt-3 bg_orange rounded">
                                <h4 class=" text-white mb-0">{{ $question['title'] }}</h4>
                                @isset($question['description'])
                                    <p class="text-white fs-desc mb-0">{{ $question['description'] }}</p>
                                @endisset
                            </div>
                        @else
                            <div class="form-group col-md-12 mt-2">
                                <label class="text_green">{{ $question['title'] }} <span
                                        class="text-danger">{{ $question['required'] ? '*' : '' }}</span></label>
                                @isset($question['description'])
                                    <p class="text-muted mb-0 fs-desc">{{ $question['description'] }}</p>
                                @endisset
                                @if ($question['answer_type'] == 'options_single')
                                    @foreach ($question['options_array'] as $key => $option)
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{ $option }}"
                                                type="radio" name="{{ $question['title'] }}"
                                                wire:model.defer="questions.{{ $index }}.answer"
                                                id="{{ $question['title'] }}{{ $key }}"
                                                {{ $loop->first ? 'required' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $question['title'] }}{{ $key }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif ($question['answer_type'] == 'options_multiple')
                                    @foreach ($question['options_array'] as $key => $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.defer="questions.{{ $index }}.answer"
                                                value="{{ $option }}"
                                                id="{{ $question['title'] }}{{ $key }}">
                                            <label class="form-check-label"
                                                for="{{ $question['title'] }}{{ $key }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif ($question['answer_type'] == 'date_picker')
                                    <input type="date" wire:model.defer="questions.{{ $index }}.answer"
                                        class="form-control @error('questions.{{ $index }}.answer') border border-danger @enderror"
                                        {{ $question['required'] ? 'required' : '' }}>
                                @else
                                    <textarea wire:model.defer="questions.{{ $index }}.answer"
                                        class="form-control @error('questions.{{ $index }}.answer') border border-danger @enderror"
                                        cols="30" rows="3" {{ $question['required'] ? 'required' : '' }}></textarea>
                                @endif
                                @error('questions.{{ $index }}.answer')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                    <div class="form-group col-12 mt-3">
                        <button type="submit" class="btn btn-orange" wire:loading.attr="disabled">Next<i
                                class="fas fa-chevron-right"></i> <span wire:loading wire:target="saveQuestions"
                                class="spinner spinner-border  spinner-border-sm"></span></button>
                    </div>
                </div>
            </form>
        </div>
    @elseif($currentStep == 2)
        <div class="row">
            <div class="col-12 p-3 rounded text-center theme-bg-7">
                <h3 class="mb-0 text_green">Program Successfully Added to Cart.</h3>
                <p class="text-center">You can checkout from cart below.</p>
                <div>
                    <a href="{{ route('shop.cart') }}" class="btn btn-orange">Go To Cart</a>
                    <a href="{{ route('programs') }}" class="btn btn-orange">Book Another Program</a>
                </div>

            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-8">
                <form wire:submit.prevent="saveOrder">
                    <div class="theme-bg-7 p-3 mb-2">
                        <div class="row">

                            <h3 class="text_green">Checkout Details</h3>

                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input wire:model.defer="order.name" type="text"
                                    class="form-control @error('order.name') border border-danger @enderror">
                                @error('order.name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input wire:model.defer="order.email" type="text"
                                    class="form-control @error('order.email') border border-danger @enderror">
                                @error('order.email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Company</label>
                                <input wire:model.defer="order.company" type="text"
                                    class="form-control @error('order.company') border border-danger @enderror">
                                @error('order.company')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input wire:model="order.phone" type="text"
                                    class="form-control @error('order.phone') border border-danger @enderror">
                                @error('order.phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>Address</label>
                                <input wire:model.defer="order.address" type="text"
                                    class="form-control @error('order.address') border border-danger @enderror">
                                @error('order.address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>Notes</label>
                                <input wire:model.defer="order.notes" type="text"
                                    class="form-control @error('order.notes') border border-danger @enderror">
                                @error('order.notes')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Details ENd -->

                    <!-- Childrens End -->
                    <div class="col-12">
                        @if (!count($filledChildrenQuestions))
                            <button class="btn btn-green" wire:loading.attr="disabled" wire:click.prevent="goBack"><i
                                    class="fas fa-chevron-left"></i> Back <span wire:loading wire:target="goBack"
                                    class="spinner spinner-border  spinner-border-sm"></span></button>
                        @endif
                        <button type="submit" class="btn btn-orange my-2 px-3" wire:loading.attr="disabled">Save &
                            Continue <i class="fas fa-chevron-right"></i> <span wire:loading wire:target="saveOrder"
                                class="spinner spinner-border  spinner-border-sm"></span></button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="p-3 theme-bg-6">
                    <h4 class="text-center text-white theme-bg-2">Payment Details</h4>
                    <table class="table table-sm">
                        <tbody>
                            @forelse($children as $index=>$child)
                                <tr>
                                    <td>Child {{ $index + 1 }}</td>
                                    <td class="text-end">{{ getCurrency() }} {{ $child['sub_total'] }}
                                        {{ $child['discount'] ? '-' . $child['discount'] . '=' . $child['net_total'] : '' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center"><small>No Child Added Yet!</small></td>
                                </tr>
                            @endforelse
                            <tr class="text_green fw-bold">
                                <td>Sub Total</td>
                                <td class="text-end">{{ getCurrency() }} {{ $subTotal }}</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="text-end">{{ getCurrency() }} {{ $discount }}</td>
                            </tr>
                            <!-- <tr>
                            <td>Vat</td>
                            <td class="text-end">{{ getCurrency() }} {{ $vat }}</td>
                        </tr> -->
                            <tr class="fw-bold text_orange theme-bg-11">
                                <td>Total</td>
                                <td class="text-end">{{ getCurrency() }} {{ $netTotal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
        <div>
            <!-- Addon products for current program  -->
            @livewire('program.addon-products-component', ['program' => $program])
        </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @this.on('fillChild', (myChildrenIndex, childrenIndex) => {
                if (myChildrenIndex != '') {
                    @this.call('fillChild', myChildrenIndex, childrenIndex)
                }
            });
        });
    </script>
</div>
