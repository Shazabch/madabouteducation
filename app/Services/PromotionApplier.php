<?php

namespace App\Services;

use App\Services\PromotionValidator;

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
        $rawSubtotal = 0;

        foreach ($products as $p) {
            $cartQuantity += $p['quantity'] ?? 1;
            $rawSubtotal += ($p['quantity'] * $p['price']);
        }

        foreach ($programsInCart as $prog) {
            if (isset($prog['children'])) {
                $cartQuantity += count($prog['children']);
                $rawSubtotal += ($prog['order']['unit_price'] * count($prog['children']));
            }
        }

        $hasProducts = count($products) > 0;
        $hasPrograms = count($programsInCart) > 0;

        $cartType = 'both';
        if ($hasProducts && !$hasPrograms)
            $cartType = 'product';
        if (!$hasProducts && $hasPrograms)
            $cartType = 'program';
        if (!$hasProducts && !$hasPrograms)
            $cartType = 'none';

        // Prepare items array for triggers
        $cartItems = [];
        foreach ($products as $p) {
            $cartItems[] = [
                'type' => 'product',
                'id' => $p['product_id'] ?? ($p['id'] ?? null),
            ];
        }
        foreach ($programsInCart as $prog) {
            $cartItems[] = [
                'type' => 'program',
                'id' => $prog['program_id'] ?? ($prog['id'] ?? null),
            ];
        }

        // Create a generic cart object for the validation logic
        $cartMock = (object) [
            'total_quantity' => $cartQuantity,
            'subtotal' => $rawSubtotal,
            'type' => $cartType,
            'items' => $cartItems,
        ];

        return $this->apply($cartMock, $user, $code);
    }

    /**
     * Apply promotions safely (READ-ONLY)
     */
    public function apply($cart, $user, $code = null)
    {
        $promotions = $this->validator
            ->getApplicablePromotions($cart, $user, $code);

        if ($promotions->isEmpty()) {
            return $this->emptyResponse();
        }

        // 🔥 Sort by priority (higher first)
        $promotions = $promotions->sortByDesc('priority');

        $totalDiscount = 0;
        $appliedPromos = [];
        $freeGifts = [];

        $allowSiblingDiscount = true;

        foreach ($promotions as $promo) {

            // ❌ If non-stackable and already applied something → stop
            if (!empty($appliedPromos) && !$promo->is_stackable) {
                break;
            }

            switch ($promo->type) {

                case 'percentage':
                    $discount = ($cart->subtotal * $promo->value) / 100;
                    break;

                case 'fixed':
                    $discount = $promo->value;
                    break;

                case 'free_gift':
                    $discount = 0;

                    // Build free gifts data structure
                    foreach ($promo->gifts as $gift) {
                        // Check if gift has specific triggers
                        $canAddGift = true;

                        // Pass products and programsInCart via full cart structure if possible
                        // The 'cart' needs to contain item details to match triggers
                        if ($gift->trigger_program_id || $gift->trigger_product_id) {
                            $canAddGift = false;

                            if (isset($cart->items)) {
                                foreach ($cart->items as $item) {
                                    if ($gift->trigger_program_id && $item['type'] === 'program' && $item['id'] == $gift->trigger_program_id) {
                                        $canAddGift = true;
                                        break;
                                    }
                                    if ($gift->trigger_product_id && $item['type'] === 'product' && $item['id'] == $gift->trigger_product_id) {
                                        $canAddGift = true;
                                        break;
                                    }
                                }
                            }
                        }

                        if ($canAddGift) {
                            $freeGifts[] = [
                                'product_id' => $gift->product_id,
                                'product_name' => $gift->product_name ?? $this->getProductName($gift->product_id),
                                'quantity' => 1,
                                'price' => 0,
                                'promotion_id' => $promo->id,
                                'promotion_name' => $promo->name,
                                'variation' => null,
                            ];
                        }
                    }
                    break;

                default:
                    $discount = 0;
            }

            // Prevent over-discount
            $discount = min($discount, $cart->subtotal - $totalDiscount);

            if ($discount > 0 || $promo->type === 'free_gift') {

                $totalDiscount += $discount;

                // Group Discount vs Sibling Discount business rule
                if ($promo->min_quantity >= 5) {
                    $allowSiblingDiscount = false;
                }

                $appliedPromos[] = [
                    'id' => $promo->id,
                    'name' => $promo->name,
                    'type' => $promo->type,
                    'discount' => $discount,
                    'min_quantity' => $promo->min_quantity,
                    'gifts' => $promo->type === 'free_gift' ? $freeGifts : [],  // ADD THIS LINE
                ];
            }
        }

        return [
            'discount' => $totalDiscount,
            'applied_promotions' => $appliedPromos,
            'free_gifts' => $freeGifts,  // ADD THIS LINE
            'allow_sibling_discount' => $allowSiblingDiscount,
        ];
    }
    private function getProductName($productId)
    {
        static $productNames = [];

        if (!isset($productNames[$productId])) {
            $product = \App\Models\Product::find($productId);
            $productNames[$productId] = $product ? $product->name : 'Free Gift';
        }

        return $productNames[$productId];
    }

    private function emptyResponse()
    {
        return [
            'discount' => 0,
            'applied_promotions' => [],
            'free_gifts' => [],  // ADD THIS LINE
            'allow_sibling_discount' => true,
        ];
    }
}
