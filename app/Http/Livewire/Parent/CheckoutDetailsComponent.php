<?php

namespace App\Http\Livewire\Parent;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Mail\NewOrderMail;
use App\Models\BookedProgram;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSubscription;
use App\Models\Program;
use App\Models\ProgramOrder;
use App\Models\ProgramOrderChildren;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Traits\WithLockedProperties;

class CheckoutDetailsComponent extends Component
{
    use WithLockedProperties;

    public $products = [];
    public $programs = [];
    public $subTotal;
    public $discount;
    public $shippingCharges = 0;
    public $vat;
    public $sst;
    public $netTotal;
    public $states = [];
    public $countries = [];
    public Order $order;
    public $programsSubTotal    = 0;
    public $programsDiscount    = 0;
    public $programsNetTotal    = 0;
    public $grandSubTotal       = 0;
    public $grandTotal          = 0;
    public $grandDiscount       = 0;
    public $payment_method      = 'ipay88';

    // Promotion Variables
    public $promoCode;
    public $promoCodeError;
    public $appliedPromoCode;
    public $promoDiscount   = 0;
    public $promotionsData  = [];

    // Free gifts resolved by PromotionApplier
    public $freeGifts = [];

    protected function rules()
    {
        return [
            'order.name'               => 'required',
            'order.email'              => 'required',
            'order.phone'              => 'required',
            'order.company'            => 'nullable',
            'order.street_address'     => 'required',
            'order.house_name_number'  => 'nullable',
            'order.postal_code'        => 'required',
            'order.city'               => 'required',
            'order.state'              => Rule::requiredIf(count($this->products) > 0),
            'order.country'            => 'nullable',
            'order.order_notes'        => 'nullable',
        ];
    }

    public function mount()
    {
        $this->order          = new Order();
        $this->order->country = 'Malaysia';
        $this->getProducts();
        $this->getStates();
        $this->countries = Country::all();
    }

    public function lockedProps()
    {
        return [
            'subTotal',
            'discount',
            'shippingCharges',
            'vat',
            'netTotal',
        ];
    }

    public function getStates()
    {
        $this->states = [
            ['name' => 'Johor',                                  'rate' => '8'],
            ['name' => 'Kedah',                                  'rate' => '8'],
            ['name' => 'Kelantan',                               'rate' => '8'],
            ['name' => 'Melaka',                                 'rate' => '8'],
            ['name' => 'Negeri Sembilan',                        'rate' => '8'],
            ['name' => 'Pahang',                                 'rate' => '8'],
            ['name' => 'Perak',                                  'rate' => '8'],
            ['name' => 'Perlis',                                 'rate' => '8'],
            ['name' => 'Pulau Pinang',                           'rate' => '8'],
            ['name' => 'Selangor',                               'rate' => '8'],
            ['name' => 'Terengganu',                             'rate' => '8'],
            ['name' => 'Wilayah Persekutuan Kuala Lumpur',       'rate' => '8'],
            ['name' => 'Wilayah Persekutuan Putrajaya',          'rate' => '8'],
            ['name' => 'Sabah',                                  'rate' => '15'],
            ['name' => 'Sarawak',                                'rate' => '15'],
            ['name' => 'Wilayah Persekutuan Labuan',             'rate' => '15'],
        ];
    }

    public function orderState()
    {
        $selectedState = $this->order['state'];
        if (!count($this->products)) {
            $this->shippingCharges = 0;
        } else {
            $maxSubscriptionMonths = collect($this->products)->pluck('subscription_months')->max();
            foreach ($this->states as $state) {
                if ($state['name'] === $selectedState) {
                    $this->shippingCharges = (float) ($state['rate'] ?? 0) * (int) ($maxSubscriptionMonths ?? 1);
                    break;
                } else {
                    $this->shippingCharges = 0;
                }
            }
        }
        $this->calculate();
    }

    public function calculate()
    {
        $this->subTotal = 0;
        foreach ($this->products as $p) {
            $this->subTotal += ($p['quantity'] * $p['price']);
        }
        $this->discount = 0;
        $this->vat      = 0;
        $this->netTotal = ($this->subTotal - $this->discount) + $this->shippingCharges + $this->vat;

        // Calculate total for programs
        $this->programsSubTotal  = 0;
        $this->programsDiscount  = 0;
        $this->programsNetTotal  = 0;
        $this->sst               = 0;

        foreach ($this->programs as $program) {
            $order = $program['order'];
            $this->programsSubTotal += $order['sub_total'];
            $this->programsDiscount += $order['discount'];
            $this->programsNetTotal += $order['net_total'];
            $this->sst              += $order['sst'];
        }

        // Calculate grand totals
        $this->grandSubTotal = $this->programsSubTotal + $this->subTotal + $this->shippingCharges;
        $this->grandDiscount = $this->programsDiscount + $this->discount;
        $this->grandTotal    = $this->netTotal + $this->programsNetTotal;

        // Evaluate promotions and merge discount into grand total
        $this->evaluatePromotions();
        if ($this->promoDiscount > 0) {
            $this->grandTotal    -= $this->promoDiscount;
            $this->grandDiscount += $this->promoDiscount;
            if ($this->grandTotal < 0) {
                $this->grandTotal = 0;
            }
        }
    }

    public function getProducts()
    {
        $this->products = session('cart') ? session('cart') : [];
        $this->programs = session('cart_programs', []);
        $this->calculate();
    }

    public function applyPromoCode()
    {
        $this->promoCodeError = null;

        if (empty($this->promoCode)) {
            $this->promoCodeError = 'Please enter a promo code.';
            return;
        }

        $result = $this->evaluatePromotions($this->promoCode);

        if (!$result) {
            $this->promoCodeError = 'Invalid or expired promo code, or requirements not met.';
            Log::info('[CheckoutDetailsComponent] Promo code failed to apply.', [
                'user_id' => optional(auth()->user())->id,
                'code'    => $this->promoCode,
            ]);
        } else {
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Promo code applied successfully!']);
            $this->calculate();
        }
    }

    public function removePromoCode()
    {
        Log::info('[CheckoutDetailsComponent] Promo code removed.', [
            'user_id' => optional(auth()->user())->id,
            'code'    => $this->appliedPromoCode,
        ]);

        $this->promoCode       = null;
        $this->appliedPromoCode = null;
        $this->promoDiscount   = 0;
        $this->promotionsData  = [];
        $this->promoCodeError  = null;
        $this->freeGifts       = [];

        $this->calculate();
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Promo code removed.']);
    }

    /**
     * Evaluate applicable promotions.
     *
     * Uses cart_free_gifts from session (written by CartComponent) as a
     * starting point. When a manual promo code is being tested, always
     * calls the applier fresh so the code-specific gifts are resolved too.
     *
     * @param  string|null $codeToApply  Manual promo code to test, or null for auto-promos.
     * @return bool  true if any discount/gift was found.
     */
    public function evaluatePromotions($codeToApply = null)
    {
        $code = $codeToApply ?? $this->appliedPromoCode;
        $user = auth()->user();

        try {
            $applier = app(\App\Services\PromotionApplier::class);
            $result  = $applier->applyToCart($this->products, $this->programs, $user, $code);
        } catch (\Throwable $e) {
            Log::error('[CheckoutDetailsComponent] Exception during evaluatePromotions.', [
                'user_id' => optional($user)->id,
                'code'    => $code,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            $this->promoDiscount  = 0;
            $this->promotionsData = [];
            $this->freeGifts      = session('cart_free_gifts', []); // fallback to session
            return false;
        }

        // Merge free gifts: prefer fresh result but fall back to session gifts
        // so that gifts added via CartComponent (program triggers) are not lost.
        $sessionGifts   = session('cart_free_gifts', []);
        $freshGifts     = $result['free_gifts'] ?? [];

        // De-duplicate by product_id + promotion_id pair
        $mergedGifts = collect(array_merge($sessionGifts, $freshGifts))
            ->unique(fn($g) => $g['product_id'] . '_' . $g['promotion_id'])
            ->values()
            ->toArray();

        $this->freeGifts = $mergedGifts;

        if ($result['discount'] > 0 || !empty($result['free_gifts']) || !empty($result['applied_promotions'])) {
            if ($codeToApply) {
                $this->appliedPromoCode = $codeToApply;
                Log::info('[CheckoutDetailsComponent] Manual promo code applied.', [
                    'user_id'  => optional($user)->id,
                    'code'     => $codeToApply,
                    'discount' => $result['discount'],
                    'gifts'    => count($this->freeGifts),
                ]);
            }
            $this->promoDiscount  = $result['discount'];
            $this->promotionsData = $result;
            return true;
        } else {
            if ($codeToApply) {
                // Code was tried but didn't qualify
                return false;
            }
            $this->promoDiscount  = 0;
            $this->promotionsData = [];
            // Do NOT clear freeGifts here — session gifts from CartComponent
            // (program-triggered gifts) should still be shown even when there
            // is no monetary discount from auto-promos.
            $this->freeGifts = $sessionGifts;
            return false;
        }
    }

    public function saveOrder()
    {
        $this->validate();
        $this->getProducts();

        // Final re-evaluation before saving so all gifts are current
        $this->evaluatePromotions($this->appliedPromoCode);

        try {
            DB::beginTransaction();

            $this->order->shipping_charges  = $this->shippingCharges;
            $this->order->sub_total         = $this->subTotal;
            $this->order->discount          = $this->discount;
            $this->order->sst               = $this->sst;
            $this->order->vat               = $this->vat;
            $this->order->net_total         = $this->netTotal;
            $this->order->programs_net_total = $this->programsNetTotal;
            $this->order->grand_net_total   = $this->grandTotal;
            $this->order->grand_sub_total   = $this->grandSubTotal;
            $this->order->grand_discount    = $this->grandDiscount;
            $this->order->payment_status    = PaymentStatus::NotPaid;
            $this->order->order_status      = OrderStatus::NotPaid;
            $this->order->user_id           = auth()->id();
            $this->order->save();

            Log::info('[CheckoutDetailsComponent] Order record saved.', [
                'order_id'     => $this->order->id,
                'user_id'      => auth()->id(),
                'grand_total'  => $this->grandTotal,
                'grand_discount' => $this->grandDiscount,
            ]);

            $subscription = null;
            foreach ($this->products as $product) {
                if ($product['is_subscription']) {
                    $subscription = ProductSubscription::create([
                        'product_id'        => $product['id'],
                        'user_id'           => auth()->id(),
                        'order_id'          => $this->order->id,
                        'start_date'        => now(),
                        'subscribed_for'    => $product['subscription_months'],
                        'end_date'          => now()->addMonths($product['subscription_months']),
                        'status'            => 'active',
                    ]);
                }

                OrderItem::create([
                    'order_id'           => $this->order->id,
                    'subscription_id'    => $subscription ? $subscription->id : null,
                    'product_id'         => $product['id'],
                    'is_subscription'    => $product['is_subscription'],
                    'subscription_months' => $product['subscription_months'],
                    'name'               => $product['name'],
                    'price'              => $product['price'],
                    'quantity'           => $product['quantity'],
                    'variation'          => array_key_exists('variation', $product) ? $product['variation'] : '',
                    'total'              => $product['price'] * $product['quantity'],
                ]);
            }

            // Save free gift order items
            if (!empty($this->freeGifts)) {
                Log::info('[CheckoutDetailsComponent] Saving free gift order items.', [
                    'order_id'   => $this->order->id,
                    'gift_count' => count($this->freeGifts),
                    'gifts'      => array_map(fn($g) => [
                        'product_id'     => $g['product_id'],
                        'product_name'   => $g['product_name'],
                        'promotion_name' => $g['promotion_name'],
                    ], $this->freeGifts),
                ]);

                foreach ($this->freeGifts as $gift) {
                    OrderItem::create([
                        'order_id'           => $this->order->id,
                        'product_id'         => $gift['product_id'],
                        'name'               => $gift['product_name'],
                        'price'              => 0,
                        'quantity'           => $gift['quantity'] ?? 1,
                        'total'              => 0,
                        'is_free_gift'       => true,
                        'promotion_id'       => $gift['promotion_id'],
                        'promotion_name'     => $gift['promotion_name'],
                        'variation'          => $gift['variation'] ?? '',
                        'is_subscription'    => false,
                        'subscription_months' => null,
                    ]);
                }
            }

            // ============================================================
            // Track promotion usage (increment used_count & track per-user)
            // ============================================================
            if ($this->appliedPromoCode) {
                try {
                    $promotion = Promotion::where('code', $this->appliedPromoCode)->first();

                    if ($promotion) {
                        // Increment global usage count
                        PromotionUsage::firstOrCreate(
                            ['promotion_id' => $promotion->id],
                            ['user_id' => auth()->id(), 'used_count' => 0]
                        )->increment('used_count');


                        // Increment user-specific usage count (if you have a user_id foreign key)
                        // Uncomment if your PromotionUsage has a user_id column:
                        // PromotionUsage::updateOrCreate(
                        //     ['promotion_id' => $promotion->id, 'user_id' => auth()->id()],
                        //     ['used_count' => DB::raw('used_count + 1')]
                        // );

                        Log::info('[CheckoutDetailsComponent] Promotion usage tracked.', [
                            'order_id'      => $this->order->id,
                            'user_id'       => auth()->id(),
                            'promotion_id'  => $promotion->id,
                            'promotion_code' => $promotion->code,
                            'total_used'    => $promotion->usages()->sum('used_count') + 1,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('[CheckoutDetailsComponent] Error tracking promotion usage.', [
                        'order_id'  => $this->order->id,
                        'user_id'   => auth()->id(),
                        'code'      => $this->appliedPromoCode,
                        'error'     => $e->getMessage(),
                    ]);
                    // Don't fail the order save — usage tracking is non-critical
                }
            }

            // Save program orders
            foreach ($this->programs as $program) {
                $program['order']['shop_order_id'] = $this->order->id;
                $program['order']['name']          = $this->order->name;
                $program['order']['email']         = $this->order->email;
                $program['order']['phone']         = $this->order->phone;
                $program['order']['company']       = $this->order->company;
                $program['order']['address']       = $this->order->full_address;

                unset($program['order']['unit_price']);
                $programOrder = ProgramOrder::create($program['order']);

                $formId = Program::where('id', $program['order']['program_id'])->value('form_id');

                foreach ($program['children'] as $child) {
                    $child['program_order_id'] = $programOrder->id;
                    $child['form_id']          = $formId;
                    ProgramOrderChildren::create($child);
                }

                $program['bookedProgram']['program_order_id'] = $programOrder->id;
                BookedProgram::create($program['bookedProgram']);

                $programOrder->generateInvoice();
                $programOrder->generateChildrenDetails();
            }

            DB::commit();

            Log::info('[CheckoutDetailsComponent] Order committed successfully.', [
                'order_id' => $this->order->id,
            ]);

            $this->order->refresh();
            $this->order->generateInvoice();

            session()->forget('cart');
            session()->forget('cart_programs');
            session()->forget('cart_free_gifts'); // clear resolved gifts from session

            $this->getProducts();
            $this->dispatchBrowserEvent('success-prompt', ['message' => 'Order Placed, Please pay to confirm the order.']);

            if ($this->payment_method == 'senangpay') {
                return redirect()->route('payment.checkout', ["shop", $this->order->id]);
            } else if ($this->payment_method == 'ipay88') {
                return redirect()->route('payment.checkout-ipay', ["shop", $this->order->id]);
            }

            $this->order = new Order();

        } catch (\Exception $e) {
            Log::error('[CheckoutDetailsComponent] Error creating shop order.', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            DB::rollBack();
            $this->dispatchBrowserEvent('error-prompt', [
                'message' => 'Something went wrong. Please refresh page and try again. If error still persists, contact admin.',
            ]);
        }
    }

    public function render()
    {
        // Sync free gifts from session on every render so the view is always current
        $sessionGifts    = session('cart_free_gifts', []);
        $this->freeGifts = !empty($this->freeGifts)
            ? collect(array_merge($sessionGifts, $this->freeGifts))
                ->unique(fn($g) => $g['product_id'] . '_' . $g['promotion_id'])
                ->values()
                ->toArray()
            : $sessionGifts;

        return view('livewire.parent.checkout-details-component');
    }
}