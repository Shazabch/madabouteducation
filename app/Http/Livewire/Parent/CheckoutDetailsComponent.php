<?php

namespace App\Http\Livewire\Parent;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Mail\NewOrderMail;
use App\Models\BookedProgram;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
use App\Services\PromotionApplier;
use App\Services\PromotionValidator;

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

    // Promotion Variables
    public $promoCode;
    public $promoCodeError;
    public $appliedPromoCode;
    public $promoDiscount   = 0;
    public $promotionsData  = [];
    public $payment_method      = 'ipay88';
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

        // Strip sibling discounts directly from the program/children objects
        // before aggregation runs, so totals are naturally correct
        $allowSiblingDiscount = $this->promotionsData['allow_sibling_discount'] ?? true;
        if (!$allowSiblingDiscount) {
            $this->programs = collect($this->programs)->map(function ($program) {
                foreach ($program['children'] as $index => &$child) {
                    if ($index > 0 && $child['discount'] > 0) {
                        $child['discount']        = 0;
                        $child['discount_detail'] = '';
                        $child['net_total']       = $child['sub_total'];
                    }
                }
                unset($child);

                // Rebuild order totals from the now-clean children
                $children                      = collect($program['children']);
                $program['order']['discount']  = $children->sum('discount');
                $program['order']['net_total'] = $children->sum('sub_total')
                    - $program['order']['discount']
                    + $program['order']['vat']
                    + $program['order']['sst'];

                return $program;
            })->toArray(); // ← back to plain array so foreach below works normally
        }

        // Calculate total for programs (reads the already-cleaned data above)
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

        // Merge promo discount into grand total
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
            return;
        }

        $this->appliedPromoCode = $this->promoCode;
        $this->promoCode        = null;
        $this->promoCodeError   = null;
        $this->calculate();
    }

    public function removePromoCode()
    {
        $this->appliedPromoCode = null;
        $this->promoCode        = null;
        $this->promoCodeError   = null;
        $this->promoDiscount    = 0;
        $this->promotionsData   = [];
        $this->calculate();

        Log::info('[CheckoutDetailsComponent] Promo code removed.', [
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Evaluate promotions and resolve free gifts
     *
     * @param string|null $codeToApply - optional promo code to apply (manual)
     * @return bool - true if promo was applied, false otherwise
     */
    public function evaluatePromotions($codeToApply = null)
    {
        $user = auth()->user();

        // Start with session gifts from CartComponent (program-triggered)
        $sessionGifts = session('cart_free_gifts', []);

        // Call PromotionApplier with actual products and programs
        // The applier builds its own cart structure internally
        $applier = app(PromotionApplier::class);
        $result = $applier->applyToCart(
            products: $this->products,
            programsInCart: $this->programs,
            user: $user,
            code: $codeToApply
        );

        // Enrich gift names — look up product names if not already set
        if (!empty($result['free_gifts'])) {
            foreach ($result['free_gifts'] as &$gift) {
                if (empty($gift['product_name'])) {
                    $product = Product::find($gift['product_id']);
                    $gift['product_name'] = $product ? $product->name : "Product #{$gift['product_id']}";
                }
            }
        }

        // Merge session gifts with fresh applier result, de-duplicate
        if (!empty($result['free_gifts'])) {
            $allGifts = collect(array_merge($sessionGifts, $result['free_gifts']))
                ->unique(fn($g) => ($g['product_id'] ?? '') . '_' . ($g['promotion_id'] ?? ''))
                ->values()
                ->toArray();
            $this->freeGifts = $allGifts;
        } else {
            $this->freeGifts = $sessionGifts;
        }

        // Store results
        $this->promoDiscount  = $result['discount'];
        $this->promotionsData = $result;

        // If a manual code was applied, check if it succeeded
        if ($codeToApply) {
            $hasDiscount = !empty($result['discount']) && $result['discount'] > 0;
            $hasGifts = !empty($result['free_gifts']);

            if ($hasDiscount || $hasGifts) {
                Log::info('Manual promo code applied successfully.');
                return true;  // ✅ SUCCESS!
            } else {
                Log::info('Manual promo code failed validation.');
                return false;  // Legitimately failed
            }
        }

        // No code = always return true
        return true;
    }

    public function saveOrder()
    {


        $this->validate();
        $this->products = session('cart', []);
        $this->programs = session('cart_programs', []); // children still have their raw discount values

        $this->evaluatePromotions($this->appliedPromoCode); // sets allow_sibling_discount correctly
        $this->calculate(); // now cleanly zeroes discount on children if promo is active,




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

            // ============================================================
            // Save free gift order items with product names populated
            // ============================================================
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
                    // Ensure product_name is populated
                    $productName = $gift['product_name'] ?? null;
                    if (empty($productName)) {
                        $product = Product::find($gift['product_id']);
                        $productName = $product ? $product->name : "Product #{$gift['product_id']}";
                    }

                    OrderItem::create([
                        'order_id'           => $this->order->id,
                        'product_id'         => $gift['product_id'],
                        'name'               => $productName,  // ← FIXED: Always populated
                        'price'              => 0,
                        'quantity'           => $gift['quantity'] ?? 1,
                        'total'              => 0,
                        'is_free_gift'       => true,
                        'promotion_id'       => $gift['promotion_id'] ?? null,
                        'promotion_name'     => $gift['promotion_name'] ?? null,
                        'variation'          => $gift['variation'] ?? '',
                        'is_subscription'    => false,
                        'subscription_months' => null,
                    ]);
                }
            }

            // ============================================================
            // Track promotion usage (both manual codes and auto-triggered)
            // ============================================================
            if (!empty($this->promotionsData['applied_promotions'])) {
                foreach ($this->promotionsData['applied_promotions'] as $appliedPromo) {
                    try {
                        $promotion = Promotion::find($appliedPromo['id']);

                        if ($promotion) {
                            // Increment global usage count
                            PromotionUsage::firstOrCreate(
                                [
                                    'promotion_id' => $promotion->id,
                                    'user_id' => auth()->id() ?? 0,
                                ],
                                ['used_count' => 0]
                            )->increment('used_count');

                            // Increment user-specific usage count (if you have a user_id column)
                            PromotionUsage::updateOrCreate(
                                ['promotion_id' => $promotion->id, 'user_id' => auth()->id()],
                                ['used_count' => DB::raw('used_count + 1')]
                            );

                            Log::info('[CheckoutDetailsComponent] Promotion usage tracked.', [
                                'order_id'      => $this->order->id,
                                'user_id'       => auth()->id(),
                                'promotion_id'  => $promotion->id,
                                'promotion_name' => $promotion->name,
                                'promotion_type' => $appliedPromo['type'],
                                'promo_code'    => $promotion->code ?? 'auto-apply',
                                'total_used'    => $promotion->usages()->sum('used_count') + 1,
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::error('[CheckoutDetailsComponent] Error tracking promotion usage.', [
                            'order_id'      => $this->order->id,
                            'user_id'       => auth()->id(),
                            'promotion_id'  => $appliedPromo['id'],
                            'error'         => $e->getMessage(),
                        ]);
                        // Don't fail the order save — usage tracking is non-critical
                    }
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
            ->unique(fn($g) => ($g['product_id'] ?? '') . '_' . ($g['promotion_id'] ?? ''))
            ->values()
            ->toArray()
            : $sessionGifts;

        return view('livewire.parent.checkout-details-component');
    }
}
