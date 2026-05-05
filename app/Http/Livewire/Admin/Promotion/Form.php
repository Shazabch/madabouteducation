<?php

namespace App\Http\Livewire\Admin\Promotion;

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

    public function mount($id = null)
    {
        if ($id) {
            $this->loadPromotion($id);
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

        $this->is_active = $promo->is_active;
        $this->is_auto = $promo->is_auto;

        $this->min_quantity = $promo->min_quantity;
        $this->min_amount = $promo->min_amount;
        $this->applies_to = $promo->applies_to;

        $this->priority = $promo->priority;
        $this->is_stackable = $promo->is_stackable;

        $this->start_date = optional($promo->start_date)->format('Y-m-d');
        $this->end_date = optional($promo->end_date)->format('Y-m-d');

        // Conditions
        foreach ($promo->conditions as $condition) {
            $this->conditions[] = [
                'type' => $condition->condition_type,
                'value' => $condition->condition_value,
            ];
        }

        // Gifts
        foreach ($promo->gifts as $gift) {
            $this->gifts[] = [
                'product_id' => $gift->product_id,
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

        session()->flash('message', 'Promotion saved successfully.');

        return redirect()->route('admin.promotions.index');
    }




    public function getParentsProperty()
    {
        return \App\Models\User::where('name', 'like', '%' . $this->searchParent . '%')
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

        $this->conditions[] = [
            'type' => $this->condition_type,
            'value' => $this->condition_value,
        ];

        $this->showConditionModal = false;
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

        $this->gifts[] = [
            'product_id' => $this->gift_product_id,
        ];

        $this->showGiftModal = false;
    }

    public function render()
    {
        return view('livewire.admin.promotion.form');
    }
}
