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
    public $gift_product_id;

    // Search
    public $searchSchool = '';
    public $searchParent = '';
    public $searchProduct = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed,free_gift',
            'value' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|max:100',

            'min_quantity' => 'nullable|integer|min:1',
            'min_amount' => 'nullable|numeric|min:0',

            'applies_to' => 'required|in:program,product,both',

            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
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
            $this->gifts[] = [
                'product_id' => $gift->product_id,
                'product_name' => $product_name ?? 'Unknown Product',
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
        $this->gifts[] = ['product_id' => null];
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
                    'code' => $this->is_auto ? null : $this->code,
                    'type' => $this->type,
                    'value' => $this->type === 'free_gift' ? null : $this->value,

                    'is_active' => $this->is_active,
                    'is_auto' => $this->is_auto,

                    'min_quantity' => $this->min_quantity,
                    'min_amount' => $this->min_amount,
                    'applies_to' => $this->applies_to,

                    'priority' => $this->priority,
                    'is_stackable' => $this->is_stackable,

                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
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
                if ($gift['product_id']) {
                    $promo->gifts()->create([
                        'product_id' => $gift['product_id'],
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
        $this->reset(['gift_product_id']);
        $this->showGiftModal = true;
    }

    public function addGiftFromModal()
    {
        if (!$this->gift_product_id) {
            return;
        }
        $product_name = Product::where('id', $this->gift_product_id)->value('title');
        $this->gifts[] = [
            'product_name' => $product_name,
            'product_id' => $this->gift_product_id,
        ];

        $this->showGiftModal = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Gift rule added']);
    }

    public function render()
    {
        return view('livewire.admin.promotion.form');
    }
}
