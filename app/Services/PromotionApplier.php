<?php

namespace App\Services;

use App\Services\PromotionValidator;
use Illuminate\Support\Facades\Log;

class PromotionApplier
{
    protected $validator;

    public function __construct(PromotionValidator $validator)
    {
        $this->validator = $validator;
    }

    public function applyToCart($products, $programsInCart, $user, $code = null)
    {
        $cartQuantity = 0;
        $rawSubtotal  = 0;

        foreach ($products as $p) {
            $cartQuantity += $p['quantity'] ?? 1;
            $rawSubtotal  += ($p['quantity'] * $p['price']);
        }

        foreach ($programsInCart as $prog) {
            if (isset($prog['children'])) {
                $cartQuantity += count($prog['children']);
                $rawSubtotal  += ($prog['order']['unit_price'] * count($prog['children']));
            }
        }

        $hasProducts = count($products) > 0;
        $hasPrograms = count($programsInCart) > 0;

        $cartType = 'both';
        if ($hasProducts && !$hasPrograms) $cartType = 'product';
        if (!$hasProducts && $hasPrograms)  $cartType = 'program';
        if (!$hasProducts && !$hasPrograms) $cartType = 'none';

        // Prepare items array for triggers
        $cartItems = [];
        foreach ($products as $p) {
            $cartItems[] = [
                'type' => 'product',
                'id'   => $p['product_id'] ?? ($p['id'] ?? null),
            ];
        }
        foreach ($programsInCart as $prog) {
            $cartItems[] = [
                'type' => 'program',
                'id'   => $prog['program_id'] ?? ($prog['order']['program_id'] ?? ($prog['id'] ?? null)),
            ];
        }

        // Create a generic cart object for the validation logic
        $cartMock = (object) [
            'total_quantity' => $cartQuantity,
            'subtotal'       => $rawSubtotal,
            'type'           => $cartType,
            'items'          => $cartItems,
        ];

        Log::info('[PromotionApplier] applyToCart called.', [
            'user_id'       => optional($user)->id,
            'promo_code'    => $code,
            'cart_type'     => $cartType,
            'cart_quantity' => $cartQuantity,
            'subtotal'      => $rawSubtotal,
            'item_ids'      => $cartItems,
        ]);

        return $this->apply($cartMock, $user, $code);
    }

    /**
     * Apply promotions safely (READ-ONLY).
     */
    public function apply($cart, $user, $code = null)
    {
        try {
            $promotions = $this->validator->getApplicablePromotions($cart, $user, $code);
        } catch (\Throwable $e) {
            Log::error('[PromotionApplier] Exception while fetching applicable promotions.', [
                'user_id' => optional($user)->id,
                'code'    => $code,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return $this->emptyResponse();
        }

        if ($promotions->isEmpty()) {
            Log::info('[PromotionApplier] No applicable promotions found.', [
                'user_id' => optional($user)->id,
                'code'    => $code,
            ]);
            return $this->emptyResponse();
        }

        Log::info('[PromotionApplier] Applicable promotions found.', [
            'user_id' => optional($user)->id,
            'count'   => $promotions->count(),
            'promos'  => $promotions->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'type' => $p->type])->toArray(),
        ]);

        // Sort by priority (higher first)
        $promotions = $promotions->sortByDesc('priority');

        $totalDiscount      = 0;
        $appliedPromos      = [];
        $freeGifts          = [];
        $allowSiblingDiscount = true;

        foreach ($promotions as $promo) {

            // If non-stackable and already applied something → stop
            if (!empty($appliedPromos) && !$promo->is_stackable) {
                Log::info('[PromotionApplier] Stopping — non-stackable promo skipped because another promo is already applied.', [
                    'skipped_promo_id'   => $promo->id,
                    'skipped_promo_name' => $promo->name,
                ]);
                break;
            }

            $discount = 0;

            try {
                switch ($promo->type) {

                    case 'percentage':
                        $discount = ($cart->subtotal * $promo->value) / 100;
                        Log::info('[PromotionApplier] Calculated percentage discount.', [
                            'promo_id'   => $promo->id,
                            'promo_name' => $promo->name,
                            'rate'       => $promo->value,
                            'subtotal'   => $cart->subtotal,
                            'discount'   => $discount,
                        ]);
                        break;

                    case 'fixed':
                        $discount = $promo->value;
                        Log::info('[PromotionApplier] Applying fixed discount.', [
                            'promo_id'   => $promo->id,
                            'promo_name' => $promo->name,
                            'discount'   => $discount,
                        ]);
                        break;

                    case 'free_gift':
                        $discount = 0;
                        $giftsAddedThisPromo = [];

                        foreach ($promo->gifts as $gift) {
                            $canAddGift = true;

                            // Check if gift has specific triggers (program or product)
                            if ($gift->trigger_program_id || $gift->trigger_product_id) {
                                $canAddGift = false;

                                if (isset($cart->items)) {
                                    foreach ($cart->items as $item) {
                                        if (
                                            $gift->trigger_program_id &&
                                            $item['type'] === 'program' &&
                                            $item['id'] == $gift->trigger_program_id
                                        ) {
                                            $canAddGift = true;
                                            Log::info('[PromotionApplier] Free gift trigger matched via program.', [
                                                'promo_id'          => $promo->id,
                                                'gift_product_id'   => $gift->product_id,
                                                'trigger_program_id' => $gift->trigger_program_id,
                                            ]);
                                            break;
                                        }
                                        if (
                                            $gift->trigger_product_id &&
                                            $item['type'] === 'product' &&
                                            $item['id'] == $gift->trigger_product_id
                                        ) {
                                            $canAddGift = true;
                                            Log::info('[PromotionApplier] Free gift trigger matched via product.', [
                                                'promo_id'          => $promo->id,
                                                'gift_product_id'   => $gift->product_id,
                                                'trigger_product_id' => $gift->trigger_product_id,
                                            ]);
                                            break;
                                        }
                                    }
                                }

                                if (!$canAddGift) {
                                    Log::info('[PromotionApplier] Free gift trigger NOT matched — gift skipped.', [
                                        'promo_id'           => $promo->id,
                                        'gift_product_id'    => $gift->product_id,
                                        'trigger_program_id' => $gift->trigger_program_id,
                                        'trigger_product_id' => $gift->trigger_product_id,
                                    ]);
                                }
                            }

                            if ($canAddGift) {
                                $giftEntry = [
                                    'product_id'     => $gift->product_id,
                                    'product_name'   => $gift->product_name ?? $this->getProductName($gift->product_id),
                                    'quantity'       => 1,
                                    'price'          => 0,
                                    'promotion_id'   => $promo->id,
                                    'promotion_name' => $promo->name,
                                    'variation'      => null,
                                ];
                                $freeGifts[]          = $giftEntry;
                                $giftsAddedThisPromo[] = $giftEntry;

                                Log::info('[PromotionApplier] Free gift added.', [
                                    'promo_id'     => $promo->id,
                                    'promo_name'   => $promo->name,
                                    'product_id'   => $gift->product_id,
                                    'product_name' => $giftEntry['product_name'],
                                ]);
                            }
                        }

                        if (empty($giftsAddedThisPromo)) {
                            Log::info('[PromotionApplier] Free-gift promo had no eligible gifts — promo skipped.', [
                                'promo_id'   => $promo->id,
                                'promo_name' => $promo->name,
                            ]);
                        }
                        break;

                    default:
                        Log::warning('[PromotionApplier] Unknown promotion type encountered.', [
                            'promo_id'   => $promo->id,
                            'promo_name' => $promo->name,
                            'type'       => $promo->type,
                        ]);
                        $discount = 0;
                }
            } catch (\Throwable $e) {
                Log::error('[PromotionApplier] Exception while processing promotion.', [
                    'promo_id'   => $promo->id,
                    'promo_name' => $promo->name,
                    'error'      => $e->getMessage(),
                    'trace'      => $e->getTraceAsString(),
                ]);
                continue; // skip this broken promo, don't halt the whole cart
            }

            // Prevent over-discount
            $discount = min($discount, $cart->subtotal - $totalDiscount);

            if ($discount > 0 || $promo->type === 'free_gift') {

                $totalDiscount += $discount;

                // Group Discount vs Sibling Discount business rule
                if ($promo->min_quantity >= 5) {
                    $allowSiblingDiscount = false;
                    Log::info('[PromotionApplier] Sibling discount disabled — group promo with min_quantity >= 5.', [
                        'promo_id'     => $promo->id,
                        'min_quantity' => $promo->min_quantity,
                    ]);
                }

                $appliedPromos[] = [
                    'id'           => $promo->id,
                    'name'         => $promo->name,
                    'type'         => $promo->type,
                    'discount'     => $discount,
                    'min_quantity' => $promo->min_quantity,
                    'gifts'        => $promo->type === 'free_gift' ? $freeGifts : [],
                ];

                Log::info('[PromotionApplier] Promotion applied successfully.', [
                    'promo_id'       => $promo->id,
                    'promo_name'     => $promo->name,
                    'type'           => $promo->type,
                    'discount'       => $discount,
                    'running_total'  => $totalDiscount,
                ]);
            } else {
                Log::info('[PromotionApplier] Promotion resulted in zero discount and no gifts — not applied.', [
                    'promo_id'   => $promo->id,
                    'promo_name' => $promo->name,
                    'type'       => $promo->type,
                ]);
            }
        }

        $response = [
            'discount'              => $totalDiscount,
            'applied_promotions'    => $appliedPromos,
            'free_gifts'            => $freeGifts,
            'allow_sibling_discount' => $allowSiblingDiscount,
        ];

        Log::info('[PromotionApplier] Final promotion result.', [
            'user_id'         => optional($user)->id,
            'total_discount'  => $totalDiscount,
            'free_gift_count' => count($freeGifts),
            'promo_count'     => count($appliedPromos),
        ]);

        return $response;
    }

    private function getProductName($productId)
    {
        static $productNames = [];

        if (!isset($productNames[$productId])) {
            try {
                $product = \App\Models\Product::find($productId);
                $productNames[$productId] = $product ? $product->title : 'Free Gift';
            } catch (\Throwable $e) {
                Log::error('[PromotionApplier] Failed to resolve product name.', [
                    'product_id' => $productId,
                    'error'      => $e->getMessage(),
                ]);
                $productNames[$productId] = 'Free Gift';
            }
        }

        return $productNames[$productId];
    }

    private function emptyResponse()
    {
        return [
            'discount'               => 0,
            'applied_promotions'     => [],
            'free_gifts'             => [],
            'allow_sibling_discount' => true,
        ];
    }
}