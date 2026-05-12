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

            return $this->emptyResponse();
        }


        // Sort by priority (higher first)
        $promotions = $promotions->sortByDesc('priority');

        $totalDiscount      = 0;
        $appliedPromos      = [];
        $freeGifts          = [];
        $allowSiblingDiscount = true;

        foreach ($promotions as $promo) {

            // If non-stackable and already applied something → stop
            if (!empty($appliedPromos) && !$promo->is_stackable) {

                break;
            }

            $discount = 0;

            try {
                switch ($promo->type) {

                    case 'percentage':
                        $discount = ($cart->subtotal * $promo->value) / 100;

                        break;

                    case 'fixed':
                        $discount = $promo->value;

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

                                            break;
                                        }
                                        if (
                                            $gift->trigger_product_id &&
                                            $item['type'] === 'product' &&
                                            $item['id'] == $gift->trigger_product_id
                                        ) {
                                            $canAddGift = true;

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
                                    'quantity'       => $gift->quantity ?? 1,
                                    'price'          => 0,
                                    'promotion_id'   => $promo->id,
                                    'promotion_name' => $promo->name,
                                    'variation'      => $gift->variation ?? null,
                                ];
                                $freeGifts[]          = $giftEntry;
                                $giftsAddedThisPromo[] = $giftEntry;
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

                        $discount = 0;
                }
            } catch (\Throwable $e) {

                continue; // skip this broken promo, don't halt the whole cart
            }

            // Prevent over-discount
            $discount = min($discount, $cart->subtotal - $totalDiscount);

            if ($discount > 0 || $promo->type === 'free_gift') {

                $totalDiscount += $discount;

                // Group Discount vs Sibling Discount business rule
                $totalChildrens = $cart->total_quantity ?? 0;
                if (is_numeric($promo->min_quantity) && $promo->min_quantity > 0) {
                    if ($totalChildrens >= $promo->min_quantity) {
                        $allowSiblingDiscount = false;
                    }
                }

                $appliedPromos[] = [
                    'id'           => $promo->id,
                    'name'         => $promo->name,
                    'type'         => $promo->type,
                    'discount'     => $discount,
                    'min_quantity' => $promo->min_quantity,
                    'gifts'        => $promo->type === 'free_gift' ? $freeGifts : [],
                ];
            } else {
            }
        }

        $response = [
            'discount'              => $totalDiscount,
            'applied_promotions'    => $appliedPromos,
            'free_gifts'            => $freeGifts,
            'allow_sibling_discount' => $allowSiblingDiscount,
        ];



        return $response;
    }

    private function getProductName($productId)
    {
        static $productNames = [];

        if (!isset($productNames[$productId])) {
            try {
                $product = \App\Models\Product::find($productId);
                // Try 'name' field first, then 'title', then fallback
                $productNames[$productId] = $product
                    ? ($product->name ?? $product->title ?? "Product #{$productId}")
                    : "Product #{$productId}";
            } catch (\Throwable $e) {

                $productNames[$productId] = "Product #{$productId}";
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
