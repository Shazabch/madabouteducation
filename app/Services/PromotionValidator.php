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
            $this->validateTriggers($promo, $cart) &&
            $this->validateConditions($promo, $user);
    }

    /**
     * Validate gifts trigger requirements
     */
    private function validateTriggers($promo, $cart)
    {
        // If promotion doesn't have gifts, this check passes
        if ($promo->type !== 'free_gift' || $promo->gifts->isEmpty()) {
            return true;
        }

        // Check if any gift requires a specific program or product trigger
        $requiresTrigger = false;
        $triggerFound = false;

        foreach ($promo->gifts as $gift) {
            if ($gift->trigger_program_id || $gift->trigger_product_id) {
                $requiresTrigger = true;

                if (isset($cart->items)) {
                    foreach ($cart->items as $item) {
                        if ($gift->trigger_program_id && $item['type'] === 'program' && $item['id'] == $gift->trigger_program_id) {
                            $triggerFound = true;
                            break 2; // Found a matching trigger
                        }
                        if ($gift->trigger_product_id && $item['type'] === 'product' && $item['id'] == $gift->trigger_product_id) {
                            $triggerFound = true;
                            break 2; // Found a matching trigger
                        }
                    }
                }
            }
        }

        // If no triggers required at all, validation passes
        if (!$requiresTrigger) {
            return true;
        }

        // If we require triggers but didn't find any, fail validation
        // NOTE: Alternatively, you might want to still allow the promo code but not grant the gift.
        // We handle that in Applier. However, if the entire promo is invalid without the trigger, we return false here.
        return $triggerFound;
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
            if ($cart->type !== 'both' && $promo->applies_to !== $cart->type) {
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

        // Group conditions by type (e.g. all parent_ids together, all school_ids together)
        // For a specific type, it acts as an OR condition (in_array)
        $groupedConditions = $promo->conditions->groupBy('condition_type');

        foreach ($groupedConditions as $type => $conditions) {
            $allowedValues = $conditions->pluck('condition_value')->toArray();

            switch ($type) {
                case 'school_id':
                    if (!isset($user->school_id) || !in_array($user->school_id, $allowedValues)) {
                        return false;
                    }
                    break;

                case 'parent_id':
                    if (!isset($user->id) || !in_array($user->id, $allowedValues)) {
                        return false;
                    }
                    break;

                // Future-safe: ignore unknown conditions instead of breaking
                default:
                    continue 2;
            }
        }

        return true;
    }
}
