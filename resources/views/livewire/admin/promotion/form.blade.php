<div wire:ignore.self class="container-fluid">

    <h2 class="mb-4">
        {{ $promoId ? 'Edit Promotion' : 'Create Promotion' }}
    </h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="save">

        <!-- Basic -->
        <div class="card mb-3">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" wire:model="name">
                    </div>

                    <div class="col-md-6">
                        <label>Code</label>
                        <input type="text" class="form-control" wire:model="code" {{ $is_auto ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label>Type</label>
                        <select class="form-control" wire:model="type">
                            <option value="">Select</option>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                            <option value="free_gift">Free Gift</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Value</label>
                        <input type="number" class="form-control" wire:model="value" {{ $type === 'free_gift' ? 'disabled' : '' }}>
                    </div>

                    <div class="col-md-4">
                        <label>Applies To</label>
                        <select class="form-control" wire:model="applies_to">
                            <option value="both">Both</option>
                            <option value="program">Program</option>
                            <option value="product">Product</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <!-- Rules -->
        <div class="card mb-3">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <label>Min Quantity</label>
                        <input type="number" class="form-control" wire:model="min_quantity">
                    </div>

                    <div class="col-md-3">
                        <label>Min Amount</label>
                        <input type="number" class="form-control" wire:model="min_amount">
                    </div>

                    <div class="col-md-3">
                        <label>Priority</label>
                        <input type="number" class="form-control" wire:model="priority">
                    </div>

                    <div class="col-md-3 d-flex align-items-center">
                        <input type="checkbox" wire:model="is_stackable"> &nbsp; Stackable
                    </div>
                </div>

            </div>
        </div>

        <!-- Conditions -->
        <div class="card mb-3">
            <div class="card-body">
                <h5>Conditions</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Value</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($conditions as $index => $condition)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $condition['type'])) }}</td>
                                <td>{{ $condition['name_display'] ?? $condition['value'] }}</td>
                                <td>
                                    <button type="button" wire:click="removeCondition({{ $index }})"
                                        class="btn btn-danger btn-sm" wire:loading.attr="disabled"
                                        wire:target="removeCondition">X</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" wire:click="openConditionModal" class="btn btn-primary btn-sm"
                    wire:loading.attr="disabled" wire:target="openConditionModal">
                    <span wire:loading.remove wire:target="openConditionModal">+ Add Condition</span>
                    <span wire:loading wire:target="openConditionModal">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </span>
                </button>
            </div>
        </div>



        @if ($type === 'free_gift' && $applies_to === 'program')
            <!-- Gifts -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Free Gifts</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Trigger Program</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($gifts as $index => $gift)
                                <tr>
                                    <td>{{ $gift['product_id'] }} - {{ $gift['product_name'] }}</td>
                                    <td>
                                        @if(!empty($gift['trigger_program_id']))
                                            {{ $gift['trigger_program_id'] }} - {{ $gift['trigger_program_name'] }}
                                        @else
                                            <span class="text-muted">Global (Any Purchase)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" wire:click="removeGift({{ $index }})"
                                            class="btn btn-danger btn-sm" wire:loading.attr="disabled"
                                            wire:target="removeGift">X</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="button" wire:click="openGiftModal" class="btn btn-primary btn-sm"
                        wire:loading.attr="disabled" wire:target="openGiftModal">
                        <span wire:loading.remove wire:target="openGiftModal">+ Add Gift</span>
                        <span wire:loading wire:target="openGiftModal">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </span>
                    </button>
                </div>
            </div>
        @endif


        @if ($showConditionModal)
            <div class="modal fade show d-block" wire:ignore.self style="background: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5>Add Condition</h5>
                            <button wire:click="$set('showConditionModal', false)" class="btn-close"></button>
                        </div>

                        <div class="modal-body">

                            <select class="form-control mb-3" wire:model="condition_type">
                                <option value="">Select Type</option>
                                <option value="school_id">School</option>
                                <option value="parent_id">Parent</option>
                            </select>

                            @if ($condition_type === 'school_id')
                                <input type="text" wire:model="searchSchool" class="form-control mb-2"
                                    placeholder="Search School">

                                @foreach ($this->schools as $school)
                                    <div wire:click="$set('condition_value', {{ $school->id }})"
                                        class="p-2 border mb-1 cursor-pointer">
                                        {{ $school->name }}
                                    </div>
                                @endforeach
                            @endif

                            @if ($condition_type === 'parent_id')
                                <input type="text" wire:model="searchParent" class="form-control mb-2"
                                    placeholder="Search Parent">

                                @foreach ($this->parents as $parent)
                                    <div wire:click="$set('condition_value', {{ $parent->id }})"
                                        class="p-2 border mb-1 cursor-pointer {{ $condition_value == $parent->id ? 'bg-success text-white' : '' }}">
                                        {{ $parent->name }}
                                        @if($condition_value == $parent->id)
                                            <span class="float-end">&check; Selected</span>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="addConditionFromModal" class="btn btn-success"
                                wire:loading.attr="disabled" wire:target="addConditionFromModal">
                                <span wire:loading.remove wire:target="addConditionFromModal">Add</span>
                                <span wire:loading wire:target="addConditionFromModal">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Adding...
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif


        @if ($showGiftModal)
            <div class="modal fade show d-block" wire:ignore.self style="background: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5>Select Product</h5>
                            <button wire:click="$set('showGiftModal', false)" class="btn-close"></button>
                        </div>

                        <div class="modal-body">

                            <label>Gift Product</label>
                            <input type="text" wire:model="searchProduct" class="form-control mb-2"
                                placeholder="Search Gift Product">

                            <div style="max-height: 150px; overflow-y: auto;">
                            @foreach ($this->products as $product)
                                <div wire:click="$set('gift_product_id', {{ $product->id }})"
                                    class="p-2 border mb-1 cursor-pointer {{ $gift_product_id == $product->id ? 'bg-success text-white' : '' }}">
                                    {{ $product->title }}
                                    @if($gift_product_id == $product->id)
                                        <span class="float-end">&check;</span>
                                    @endif
                                </div>
                            @endforeach
                            </div>

                            <hr>
                            <label>Trigger Program (Optional - if left blank, applies to all items)</label>
                            <input type="text" wire:model.debounce.300ms="searchProgram" class="form-control mb-2" placeholder="Search Program">
                            <div style="max-height: 150px; overflow-y: auto;">
                            @foreach ($this->programs as $program)
                                <div wire:click="$set('gift_trigger_id', {{ $program->id }})"
                                    class="p-2 border mb-1 cursor-pointer {{ $gift_trigger_id == $program->id ? 'bg-success text-white' : '' }}">
                                    {{ $program->title }}
                                    @if($gift_trigger_id == $program->id)
                                        <span class="float-end">&check;</span>
                                    @endif
                                </div>
                            @endforeach
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="addGiftFromModal" class="btn btn-success"
                                wire:loading.attr="disabled" wire:target="addGiftFromModal">
                                <span wire:loading.remove wire:target="addGiftFromModal">Add Gift</span>
                                <span wire:loading wire:target="addGiftFromModal">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Adding...
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif


        <!-- Submit -->
        <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save Promotion</span>
            <span wire:loading wire:target="save">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...
            </span>
        </button>

    </form>

</div>