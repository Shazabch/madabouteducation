<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionValidator
{
    /**
     * Get all applicable promotions
     *
     * @param object $cart  (expects: total_quantity, subtotal, type)
     * @param object $user  (expects: id, school_id optional)
     * @param string|null $code
     * @return \Illuminate\Support\Collection
     */
    public function getApplicablePromotions($cart, $user, $code = null)
    {
        $query = Promotion::where('is_active', true);

        // If user entered promo code
        if ($code) {
            $query->where('code', $code);
        } else {
            // Auto promotions only
            $query->where('is_auto', true);
        }

        $promotions = $query->with(['conditions', 'gifts'])->get();

        return $promotions->filter(function ($promo) use ($cart, $user) {
            return $this->isValid($promo, $cart, $user);
        })->values(); // reset keys
    }

    /**
     * Master validation
     */
    private function isValid($promo, $cart, $user)
    {
        return
            $this->validateDate($promo) &&
            $this->validateCart($promo, $cart) &&
            $this->validateConditions($promo, $user);
    }

    /**
     * Validate date range
     */
    private function validateDate($promo)
    {
        if ($promo->start_date && now()->lt($promo->start_date)) {
            return false;
        }

        if ($promo->end_date && now()->gt($promo->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Validate cart-related rules
     */
    private function validateCart($promo, $cart)
    {
        // Minimum quantity (e.g. group discount)
        if (!empty($promo->min_quantity) && $cart->total_quantity < $promo->min_quantity) {
            return false;
        }

        // Minimum amount
        if (!empty($promo->min_amount) && $cart->subtotal < $promo->min_amount) {
            return false;
        }

        // Applies to (program/product/both)
        if (!empty($promo->applies_to) && $promo->applies_to !== 'both') {
            if ($promo->applies_to !== $cart->type) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate conditions (school, parent, etc.)
     */
    private function validateConditions($promo, $user)
    {
        if ($promo->conditions->isEmpty()) {
            return true;
        }

        foreach ($promo->conditions as $condition) {

            switch ($condition->condition_type) {

                case 'school_id':
                    if (!isset($user->school_id) || $user->school_id != $condition->condition_value) {
                        return false;
                    }
                    break;

                case 'parent_id':
                    if ($user->id != $condition->condition_value) {
                        return false;
                    }
                    break;

                // Future-safe: ignore unknown conditions instead of breaking
                default:
                    continue;
            }
        }

        return true;
    }
}
