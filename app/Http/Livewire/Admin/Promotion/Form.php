<?php

namespace App\Http\Livewire\Admin\Promotion;

use App\Models\Product;
use Livewire\Component;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $promoId;

    // Basic
    public $name, $code, $type, $value;
    public $is_active = true, $is_auto = false;

    // Rules
    public $min_quantity, $min_amount, $applies_to = 'both';
    public $priority = 0, $is_stackable = false;

    // limits
    public $max_uses, $max_uses_per_user;

    // Dates
    public $start_date, $end_date;

    // Dynamic
    public $conditions = [];
    public $gifts = [];

    // Modal controls
    public $showConditionModal = false;
    public $showGiftModal = false;


    // Temp fields (for modal)
    public $condition_type, $condition_value;
    public $gift_product_id, $gift_trigger_id;

    // Search
    public $searchSchool = '';
    public $searchParent = '';
    public $searchProduct = '';
    public $searchProgram = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed,free_gift',
            'value' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|max:100',

            'min_quantity' => 'nullable|integer|min:0',
            'min_amount' => 'nullable|numeric|min:0',

            'applies_to' => 'required|in:program,product,both',

            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_uses' => 'nullable|integer|min:0',
            'max_uses_per_user' => 'nullable|integer|min:0',
        ];
    }

    public function mount($promoId = null)
    {
        if ($promoId) {
            $this->loadPromotion($promoId);
        }
    }

    private function loadPromotion($id)
    {
        $promo = Promotion::with(['conditions', 'gifts'])->findOrFail($id);

        $this->promoId = $promo->id;

        $this->name = $promo->name;
        $this->code = $promo->code;
        $this->type = $promo->type;
        $this->value = $promo->value;

        // ... rest of loading ...
        $this->is_active = $promo->is_active;
        $this->is_auto = $promo->is_auto;

        $this->min_quantity = $promo->min_quantity;
        $this->min_amount = $promo->min_amount;
        $this->applies_to = $promo->applies_to;
        $this->max_uses = $promo->max_uses;
        $this->max_uses_per_user = $promo->max_uses_per_user;

        $this->priority = $promo->priority;
        $this->is_stackable = $promo->is_stackable;

        $this->start_date = optional($promo->start_date)->format('Y-m-d');
        $this->end_date = optional($promo->end_date)->format('Y-m-d');

        // Conditions with lookup names
        foreach ($promo->conditions as $condition) {
            $nameDisplay = $condition->condition_value;
            if ($condition->condition_type === 'parent_id') {
                $user = \App\Models\User::find($condition->condition_value);
                if ($user) {
                    $nameDisplay = $user->name . ' (ID: ' . $user->id . ')';
                }
            } elseif ($condition->condition_type === 'school_id') {
                // If you have a School model, look it up. Using generic ID fallback.
                $nameDisplay = 'School ID: ' . $condition->condition_value;
            }

            $this->conditions[] = [
                'type' => $condition->condition_type,
                'value' => $condition->condition_value,
                'name_display' => $nameDisplay,
            ];
        }

        // Gifts with lookup names
        foreach ($promo->gifts as $gift) {
            $product_name = \App\Models\Product::where('id', $gift->product_id)->value('title');

            $trigger_program_name = $gift->trigger_program_id ? \App\Models\Program::where('id', $gift->trigger_program_id)->value('title') : null;
            $trigger_product_name = $gift->trigger_product_id ? \App\Models\Product::where('id', $gift->trigger_product_id)->value('title') : null;

            $this->gifts[] = [
                'product_id' => $gift->product_id,
                'product_name' => $product_name ?? 'Unknown Product',
                'trigger_program_id' => $gift->trigger_program_id,
                'trigger_program_name' => $trigger_program_name,
                'trigger_product_id' => $gift->trigger_product_id,
                'trigger_product_name' => $trigger_product_name,
            ];
        }
    }

    // ------------------------
    // Dynamic Rows
    // ------------------------

    public function addCondition()
    {
        $this->conditions[] = ['type' => '', 'value' => ''];
    }

    public function removeCondition($index)
    {
        unset($this->conditions[$index]);
        $this->conditions = array_values($this->conditions);
    }

    public function addGift()
    {
        $this->gifts[] = [
            'product_id' => null,
            'trigger_program_id' => null,
            'trigger_product_id' => null,
        ];
    }

    public function removeGift($index)
    {
        unset($this->gifts[$index]);
        $this->gifts = array_values($this->gifts);
    }

    // ------------------------
    // Save
    // ------------------------

    public function save()
    {
        $this->validate();

        DB::transaction(function () {

            $promo = Promotion::updateOrCreate(
                ['id' => $this->promoId],
                [
                    'name' => $this->name,
                    'code' => $this->code,
                    'type' => $this->type,
                    'value' => $this->type === 'free_gift' ? null : $this->value,

                    'is_active' => $this->is_active,
                    'is_auto' => $this->type === 'free_gift' ? true : $this->is_auto,

                    'min_quantity' => $this->min_quantity,
                    'min_amount' => $this->min_amount,
                    'applies_to' => $this->applies_to,

                    'priority' => $this->priority,
                    'is_stackable' => $this->is_stackable,

                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'max_uses' => $this->max_uses,
                    'max_uses_per_user' => $this->max_uses_per_user,
                ]
            );

            // Reset relations
            $promo->conditions()->delete();
            $promo->gifts()->delete();

            // Save conditions
            foreach ($this->conditions as $condition) {
                if ($condition['type'] && $condition['value']) {
                    $promo->conditions()->create([
                        'condition_type' => $condition['type'],
                        'condition_value' => $condition['value'],
                    ]);
                }
            }

            // Save gifts
            foreach ($this->gifts as $gift) {
                if (!empty($gift['product_id'])) {
                    $promo->gifts()->create([
                        'product_id' => $gift['product_id'],
                        'trigger_program_id' => $gift['trigger_program_id'] ?? null,
                        'trigger_product_id' => $gift['trigger_product_id'] ?? null,
                    ]);
                }
            }
        });

        $this->dispatchBrowserEvent('success-notification', ['message' => 'Promotion saved successfully!']);

        return redirect()->route('admin.promotions.index');
    }




    public function getParentsProperty()
    {
        return \App\Models\User::where('name', 'like', '%' . $this->searchParent . '%')
            ->where('is_admin', 0)
            ->limit(10)
            ->get();
    }

    public function getProductsProperty()
    {
        return \App\Models\Product::where('title', 'like', '%' . $this->searchProduct . '%')
            ->limit(10)
            ->get();
    }

    public function getProgramsProperty()
    {
        return \App\Models\Program::where('title', 'like', '%' . $this->searchProgram . '%')
            ->limit(10)
            ->get();
    }

    public function openConditionModal()
    {
        $this->reset(['condition_type', 'condition_value']);
        $this->showConditionModal = true;
    }

    public function addConditionFromModal()
    {
        if (!$this->condition_type || !$this->condition_value) {
            return;
        }

        $nameDisplay = $this->condition_value;
        if ($this->condition_type === 'parent_id') {
            $user = \App\Models\User::find($this->condition_value);
            if ($user) $nameDisplay = $user->name;
        }

        $this->conditions[] = [
            'type' => $this->condition_type,
            'value' => $this->condition_value,
            'name_display' => $nameDisplay,
        ];

        $this->showConditionModal = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Condition added']);
    }

    public function openGiftModal()
    {
        $this->reset(['gift_product_id', 'gift_trigger_id', 'searchProduct', 'searchProgram']);
        $this->showGiftModal = true;
    }

    public function addGiftFromModal()
    {
        if (!$this->gift_product_id) {
            return;
        }
        $product_name = Product::where('id', $this->gift_product_id)->value('title');

        $trigger_program_id = null;
        $trigger_program_name = null;

        if ($this->gift_trigger_id) {
            $trigger_program_id = $this->gift_trigger_id;
            $trigger_program_name = \App\Models\Program::where('id', $this->gift_trigger_id)->value('title');
        }

        $this->gifts[] = [
            'product_name' => $product_name ?? 'Unknown Product',
            'product_id' => $this->gift_product_id,
            'trigger_program_id' => $trigger_program_id,
            'trigger_program_name' => $trigger_program_name,
            'trigger_product_id' => null,
            'trigger_product_name' => null,
        ];

        $this->showGiftModal = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Gift rule added']);
    }

    public function render()
    {
        return view('livewire.admin.promotion.form');
    }
}
