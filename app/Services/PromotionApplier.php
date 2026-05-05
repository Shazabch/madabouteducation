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

                    foreach ($promo->gifts as $gift) {
                        $freeGifts[] = [
                            'product_id' => $gift->product_id,
                            'price' => 0
                        ];
                    }
                    break;

                default:
                    $discount = 0;
            }

            // Prevent over-discount
            $discount = min($discount, $cart->subtotal - $totalDiscount);

            if ($discount > 0 || $promo->type === 'free_gift') {

                $totalDiscount += $discount;

                $appliedPromos[] = [
                    'id' => $promo->id,
                    'name' => $promo->name,
                    'type' => $promo->type,
                    'discount' => $discount,
                ];
            }
        }

        return [
            'discount' => $totalDiscount,
            'applied_promotions' => $appliedPromos,
            'free_gifts' => $freeGifts,
        ];
    }

    private function emptyResponse()
    {
        return [
            'discount' => 0,
            'applied_promotions' => [],
            'free_gifts' => [],
        ];
    }
}
