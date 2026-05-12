<?php

namespace App\Http\Livewire\Parent;

use App\Models\Product;
use App\Models\Program;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CartComponent extends Component
{
    public $products;
    public $subTotal = 0;
    public $total = 0;
    public $programsSubTotal = 0;
    public $programsDiscount = 0;
    public $programsNetTotal = 0;
    public $sst = 0;
    public $subscriptionPrice = 0;
    public $grandTotal = 0;

    // Promotion Variables
    public $promoDiscount = 0;
    public $promotionsData = [];

    // Free Gifts resolved from promotions
    public $freeGifts = [];

    protected function getListeners()
    {
        return [
            'add' => 'addToCart',
            'addProgram' => 'addProgramToCart'
        ];
    }

    public function calculate()
    {
        $this->subTotal = 0;
        foreach ($this->products as $p) {
            $product = Product::find($p['id']);

            if ($product->is_subscription) {
                // Subscription product (Always add once, no quantity)
                $this->subTotal += $p['price'];
            } else {
                // Regular product
                $this->subTotal += ($p['quantity'] * $p['price']);
            }
        }
        $this->total = $this->subTotal;

        // Calculate total for programs
        $this->programsSubTotal = 0;
        $this->programsDiscount = 0;
        $this->programsNetTotal = 0;

        // Get data from session
        $programsInCart = collect(session('cart_programs', []));
        $this->sst = 0;

        // Foreach order
        foreach ($programsInCart as $program) {
            $order = $program['order'];
            $this->programsSubTotal += $order['sub_total'];
            $this->programsDiscount += $order['discount'];
            $this->programsNetTotal += $order['net_total'];
            $this->sst += $order['sst'];
        }
        $this->grandTotal = $this->total + $this->programsNetTotal;

        // Re-evaluate promotions after totals are calculated
        $this->evaluatePromotions();
        if ($this->promoDiscount > 0) {
            $this->grandTotal -= $this->promoDiscount;
            // ensure it doesn't go negative
            if ($this->grandTotal < 0) {
                $this->grandTotal = 0;
            }
        }
    }

    /**
     * Evaluate promotions (auto-apply only, no promo code here).
     * Persists free_gifts to session so CheckoutDetailsComponent
     * and other components can read them without re-evaluating.
     */
    public function evaluatePromotions()
    {
        $user = auth()->user();

        // Get arrays directly safely
        $products = $this->products ?: [];
        $programsInCart = session('cart_programs', []);

        try {
            $applier = app(\App\Services\PromotionApplier::class);
            $result = $applier->applyToCart($products, $programsInCart, $user);

            // Sync free gifts to session so they are available cart-wide
            $this->freeGifts = $result['free_gifts'] ?? [];
            $this->syncFreeGiftsToSession($this->freeGifts);

            if ($result['discount'] > 0 || !empty($result['free_gifts']) || !empty($result['applied_promotions'])) {
                $this->promoDiscount = $result['discount'];
                $this->promotionsData = $result;
                return true;
            } else {
                $this->promoDiscount = 0;
                $this->promotionsData = [];
                $this->freeGifts = [];
                $this->syncFreeGiftsToSession([]);
                return false;
            }
        } catch (\Throwable $e) {
            Log::error('[CartComponent] Exception during evaluatePromotions', [
                'user_id' => optional($user)->id,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

    /**
     * Persist the resolved free gifts list to session.
     * This is the single source of truth read by CheckoutDetailsComponent.
     */
    private function syncFreeGiftsToSession(array $gifts): void
    {
        if (empty($gifts)) {
            session()->forget('cart_free_gifts');
            Log::info('[CartComponent] Free gifts cleared from session.');
        } else {
            session()->put('cart_free_gifts', $gifts);
            Log::info('[CartComponent] Free gifts synced to session.', [
                'gift_count' => count($gifts),
                'gifts'      => array_map(fn($g) => [
                    'product_id'     => $g['product_id'],
                    'product_name'   => $g['product_name'],
                    'promotion_name' => $g['promotion_name'],
                ], $gifts),
            ]);
        }
    }

    public function addToCart($id, $quantity = 'empty', $variation = null, $price = 0, $months = 0)
    {
        $this->subscriptionPrice = $price;
        $product = Product::find($id);
        if ($quantity != 'empty' && $quantity < 1 && !$product->is_subscription) {
            $this->remove($id, $variation);
            return;
        }

        if ($quantity == 'empty') {
            $quantity = 1;
        }

        if (!$product) {
            $this->dispatchBrowserEvent('error-prompt', ['message' => 'Product Not Found!']);
            return 1;
        }

        $cartFromSession = session()->get('cart');
        if (!$cartFromSession) {
            $cartFromSession = [];
        }

        $cartCollection = collect($cartFromSession);
        $variationImage = null;
        if ($variation) {
            $variationImage = $product->variations()->where('title', $variation)->first()->image;
        }
        $productToAdd = [
            "id"                 => $product->id,
            "name"               => $product->title,
            "quantity"           => $product->is_subscription ? 1 : $quantity,
            "price"              => $product->is_subscription ? $price : $product->price,
            "slug"               => $product->slug,
            "photo"              => $variationImage ? $variationImage : $product->main_image,
            "variation"          => $variation,
            "is_subscription"    => $product->is_subscription,
            "subscription_months" => $months,
        ];

        $f = null;
        if ($variation) {
            $f = $cartCollection->where('id', $product->id)->where('variation', $variation)->first();
        } else {
            $f = $cartCollection->where('id', $product->id)->where('variation', '')->first();
        }

        if ($f) {
            $cartCollection = $cartCollection->map(function ($item, $key) use ($product, $quantity, $variation) {
                if ($item['id'] == $product->id && $item['variation'] == $variation) {
                    $item['quantity'] = $product->is_subscription ? 1 : $quantity;
                    $item['variation'] = $variation;
                }
                return $item;
            });
        } else {
            $cartCollection->push($productToAdd);
        }

        session()->put('cart', $cartCollection->toArray());

        // Re-evaluate promotions; free gifts are synced inside evaluatePromotions()
        //$this->evaluatePromotions();

        $this->emit('productAdded');
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Product added to cart successfully!']);
    }

    public function remove($productId, $variation = null)
    {
        $cartFromSession = session()->get('cart');
        if (!$cartFromSession) {
            $this->emit('productRemoved');
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Product removed successfully']);
            return;
        }
        $cartCollection = collect($cartFromSession);

        $cartCollection = $cartCollection->filter(function ($item) use ($productId, $variation) {
            return $item['id'] != $productId || $item['variation'] != $variation;
        });
        session()->put('cart', $cartCollection->toArray());

        // Re-evaluate so gifts are removed if they depended on this product
        $this->evaluatePromotions();

        $this->emit('productRemoved');
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Product removed successfully']);
    }

    /**
     * Add a program to cart and immediately resolve any free gifts it triggers.
     */
    public function addProgramToCart($data)
    {
        $uuid = Str::uuid()->toString();
        $data['cart_id'] = $uuid;

        // Retrieving the existing array from the session
        $existingPrograms = session('cart_programs', []);

        // Appending a new record to the array
        $existingPrograms[] = $data;

        // Storing the updated array back in the session
        session()->put('cart_programs', $existingPrograms);

        Log::info('[CartComponent] Program added to cart.', [
            'program_id' => $data['order']['program_id'] ?? null,
            'cart_id'    => $uuid,
            'user_id'    => optional(auth()->user())->id,
        ]);

        // Evaluate promotions — this resolves gifts triggered by this program
        // and persists them to session via syncFreeGiftsToSession()
        $this->evaluatePromotions();

        // Notify user about any new free gift
        $this->notifyFreeGiftsIfNew();

        $this->emit('productAdded');
        $this->recalculatePrograms();

        $this->dispatchBrowserEvent('success-notification', ['message' => 'Program added to cart successfully!']);
    }

    public function removeProgram($cartId)
    {
        // Retrieve the program before removal so we can log it
        $existingPrograms = collect(session('cart_programs', []));
        $removedProgram = $existingPrograms->firstWhere('cart_id', $cartId);

        // Filter out the removed program
        $existingPrograms = $existingPrograms->filter(function ($program) use ($cartId) {
            return $program['cart_id'] !== $cartId;
        });

        // Storing the updated array back in the session
        session()->put('cart_programs', $existingPrograms->toArray());

        Log::info('[CartComponent] Program removed from cart.', [
            'cart_id'    => $cartId,
            'program_id' => $removedProgram['order']['program_id'] ?? null,
            'user_id'    => optional(auth()->user())->id,
        ]);

        // Re-evaluate promotions so gifts tied to this program are removed from session
        $this->evaluatePromotions();

        $this->recalculatePrograms();

        $this->dispatchBrowserEvent('success-notification', ['message' => 'Program Removed From Cart!']);
    }

    /**
     * Dispatch a browser notification if any new free gift was just added to session.
     * Compares current session gifts against previously known gifts stored in promotionsData.
     */
    private function notifyFreeGiftsIfNew(): void
    {
        if (empty($this->freeGifts)) {
            return;
        }

        $giftNames = implode(', ', array_map(fn($g) => $g['product_name'], $this->freeGifts));
        $this->dispatchBrowserEvent('success-notification', [
            'message' => "🎁 Free gift(s) added to your order: {$giftNames}",
        ]);
    }

    public function recalculatePrograms()
    {
        // Retrieving the existing array from the session
        $existingPrograms = collect(session('cart_programs', []));

        // Re-evaluate promotions so we know if there's a group discount
        $tempSubtotal = 0;
        foreach (session('cart', []) as $p) {
            $tempSubtotal += ($p['quantity'] * $p['price']);
        }
        $tempProgramSubtotal = 0;
        foreach ($existingPrograms as $prog) {
            $tempProgramSubtotal += $prog['order']['unit_price'] * count($prog['children']);
        }

        $this->subTotal = $tempSubtotal;
        $this->programsSubTotal = $tempProgramSubtotal;
        $this->evaluatePromotions();

        // The flag is now fully controlled and centralized by the Applier
        $allowSiblingDiscount = $this->promotionsData['allow_sibling_discount'] ?? true;

        // Group by program_id
        $groupedPrograms = $existingPrograms->groupBy(function ($item) {
            return $item['order']['program_id'];
        });

        // Get all the programs which are two times in cart, check by program_id
        $filteredGroups = $groupedPrograms->filter(function ($group) {
            return $group->count() > 1;
        });

        // Sort the groups by unit_price, highest to lowest
        $filteredGroups = $filteredGroups->map(function ($group) {
            return $group->sortByDesc('order.unit_price');
        });

        $updatedPrograms = collect();

        foreach ($filteredGroups as $group) {
            $iteration = 1;
            foreach ($group as $programInCart) {
                $pId = $programInCart['bookedProgram']['program_id'];
                $bProgramme = Program::where('id', $pId)->first();
                $subTotal = 0;
                $discount = 0;
                $vat = 0;
                $netTotal = 0;

                $count = 1;
                foreach ($programInCart['children'] as $index => $child) {
                    $child['sub_total'] = $programInCart['order']['unit_price'];
                    if ($bProgramme->type == null && ($count > 1 || $iteration > 1)) {
                        if (!$allowSiblingDiscount) {
                            $child['discount'] = 0;
                            $child['discount_detail'] = '';
                        } else {
                            $child['discount'] = (10 / 100) * $child['sub_total'];
                            $child['discount_detail'] = $child['discount'] > 0 ? '10% discount for sibling' : '';
                        }
                    } else if ($bProgramme->type == 'sevent' && ($count > 1 || $iteration > 1)) {
                        $child['discount'] = 0;
                        $child['discount_detail'] = '';
                    } else if (($bProgramme->type == 'dom' || $bProgramme->type == 'mom') && ($count > 1 || $iteration > 1)) {
                        $child['discount'] = 0;
                        $subTotal += 250;
                        $child['discount_detail'] = '';
                    } else {
                        $child['discount'] = 0;
                        $child['discount_detail'] = '';
                    }
                    $child['net_total'] = $child['sub_total'] - $child['discount'];
                    $programInCart['children'][$index] = $child;
                    $count++;
                }

                $children_collection = collect($programInCart['children']);
                $subTotal = $children_collection->sum('sub_total');
                $discount = $children_collection->sum('discount');
                $sst = 0;
                if ($programInCart['order']['sst'] > 0) {
                    $sst = ($subTotal - $discount) * (getSstValue());
                }
                $vat = 0;
                $netTotal = ($subTotal - $discount) + $vat + $sst;

                $programInCart['order']['sub_total'] = $subTotal;
                $programInCart['order']['discount'] = $discount;
                $programInCart['order']['sst'] = $sst;
                $programInCart['order']['vat'] = $vat;
                $programInCart['order']['net_total'] = $netTotal;

                $updatedPrograms = $updatedPrograms->merge(collect([$programInCart]));
                $iteration++;
            }
        }

        $existingPrograms = $existingPrograms->keyBy('cart_id');

        $updatedPrograms->each(function ($item) use ($existingPrograms) {
            $cartId = $item['cart_id'];
            if ($existingPrograms->has($cartId)) {
                $existingPrograms[$cartId] = $item;
            }
        });

        $existingPrograms = $existingPrograms->values();

        session()->put('cart_programs', $existingPrograms);
    }

    // This function is for restoring cart programs while debugging
    // It does not affect any other data
    public function restore()
    {
        $personal_laptop = '[{"order":{"name":null,"email":null,"phone":null,"company":null,"address":null,"notes":null,"booked_for_date":"2023-09-27","program_id":3000,"program_title":"jungle camp","sub_total":200,"discount":10,"vat":0,"net_total":190,"payment_status":"not_paid","children_count":2,"user_id":1000,"group_id":1,"unit_price":"100"},"children":[{"program_order_id":null,"name":"asd","age":"12","passport_no":"123","date_of_birth":"2023-09-27","gender":"Male","nationality":"Azerbaijani","guardian":"{\"name\":\"Zahir Huber\",\"relationship\":\"sad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Azerbaijani\",\"residential_address\":\"Ea qui irure sunt en\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asdsad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Bahraini\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"{}","sub_total":"100","discount":0,"discount_detail":"","net_total":100},{"program_order_id":null,"name":"asd","age":"12","passport_no":"123","date_of_birth":"2023-09-27","gender":"Male","nationality":"Azerbaijani","guardian":"{\"name\":\"Zahir Huber\",\"relationship\":\"sad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Azerbaijani\",\"residential_address\":\"Ea qui irure sunt en\"}","guardian2":"{\"name\":\"Zahir Huber\",\"relationship\":\"asdsad\",\"email\":\"gugi@mailinator.com\",\"contact_no\":\"123\",\"nationality\":\"Bahraini\",\"residential_address\":\"Ea qui irure sunt en\"}","questions":"{}","sub_total":"100","discount":10,"discount_detail":"10% discount for sibling","net_total":90}],"bookedProgram":{"program_id":3000,"group_id":1,"program_order_id":null,"title":"jungle camp","venue":"Lahore","start_date":"2023-09-27","end_date":"2023-09-30","age_group":"12-18","age_group_extra_info":"older allowed","price":"100","pick_and_drop":"Thokar","timetable":"[]","time":"8:00 AM"},"cart_id":"4506325a-f17f-4d2a-9750-a37483dca7fb"}]';
        $existingp = json_decode($personal_laptop, true);
        session()->put('cart_programs', $existingp);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Restored!']);
    }

    public function render()
    {
        $cartPrograms = collect(session('cart_programs', []));
        $productsFromSession = collect(session('cart'));
        if ($productsFromSession->isEmpty()) {
            $this->products = [];
        } else {
            $this->products = $productsFromSession->toArray();
        }
        $this->calculate();

        // Sync freeGifts from session so the blade template always has the latest list
        $this->freeGifts = session('cart_free_gifts', []);

        $cartPrograms = collect(session('cart_programs', []));
        return view('livewire.parent.cart-component', compact('cartPrograms'));
    }
}