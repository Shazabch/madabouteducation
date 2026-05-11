<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Support\Facades\Log;

class PromotionValidator
{
    /**
     * Get all applicable promotions.
     *
     * @param object      $cart  (expects: total_quantity, subtotal, type, items)
     * @param object      $user  (expects: id, school_id optional)
     * @param string|null $code
     * @return \Illuminate\Support\Collection
     */
    public function getApplicablePromotions($cart, $user, $code = null)
    {
        $query = Promotion::where('is_active', true);

        if ($code) {
            $query->where('code', $code);
            Log::info('[PromotionValidator] Evaluating promo code.', ['code' => $code]);
        } else {
            $query->where('is_auto', true);
            Log::info('[PromotionValidator] Evaluating auto promotions.');
        }

        $promotions = $query->with(['conditions', 'gifts'])->get();

        Log::info('[PromotionValidator] Promotions fetched from DB.', [
            'count'  => $promotions->count(),
            'ids'    => $promotions->pluck('id')->toArray(),
        ]);

        $filtered = $promotions->filter(function ($promo) use ($cart, $user) {
            $valid = $this->isValid($promo, $cart, $user);

            if (!$valid) {
                Log::info('[PromotionValidator] Promotion failed validation — excluded.', [
                    'promo_id'   => $promo->id,
                    'promo_name' => $promo->name,
                ]);
            }

            return $valid;
        })->values();

        Log::info('[PromotionValidator] Applicable promotions after filtering.', [
            'count' => $filtered->count(),
            'ids'   => $filtered->pluck('id')->toArray(),
        ]);

        return $filtered;
    }

    /**
     * Master validation — all checks must pass.
     */
    private function isValid($promo, $cart, $user): bool
    {
        return
            $this->validateDate($promo) &&
            $this->validateCart($promo, $cart) &&
            $this->validateTriggers($promo, $cart) &&
            $this->validateConditions($promo, $user);
    }

    /**
     * Validate gift trigger requirements.
     * If a free_gift promo has gifts that require a specific program/product trigger,
     * at least one cart item must match.
     */
    private function validateTriggers($promo, $cart): bool
    {
        // Non-gift promotions always pass this check
        if ($promo->type !== 'free_gift' || $promo->gifts->isEmpty()) {
            return true;
        }

        $requiresTrigger = false;
        $triggerFound    = false;

        foreach ($promo->gifts as $gift) {
            if ($gift->trigger_program_id || $gift->trigger_product_id) {
                $requiresTrigger = true;

                if (isset($cart->items)) {
                    foreach ($cart->items as $item) {
                        if (
                            $gift->trigger_program_id &&
                            $item['type'] === 'program' &&
                            $item['id'] == $gift->trigger_program_id
                        ) {
                            $triggerFound = true;
                            break 2;
                        }
                        if (
                            $gift->trigger_product_id &&
                            $item['type'] === 'product' &&
                            $item['id'] == $gift->trigger_product_id
                        ) {
                            $triggerFound = true;
                            break 2;
                        }
                    }
                }
            }
        }

        // No triggers required → passes
        if (!$requiresTrigger) {
            return true;
        }

        if (!$triggerFound) {
            Log::info('[PromotionValidator] FREE GIFT — trigger required but not found in cart.', [
                'promo_id'   => $promo->id,
                'promo_name' => $promo->name,
                'triggers'   => $promo->gifts->map(fn($g) => [
                    'trigger_program_id' => $g->trigger_program_id,
                    'trigger_product_id' => $g->trigger_product_id,
                ])->toArray(),
                'cart_items' => $cart->items ?? [],
            ]);
        }

        return $triggerFound;
    }

    /**
     * Validate date range.
     */
    private function validateDate($promo): bool
    {
        if ($promo->start_date && now()->lt($promo->start_date)) {
            Log::info('[PromotionValidator] Promotion not yet started.', [
                'promo_id'   => $promo->id,
                'promo_name' => $promo->name,
                'start_date' => $promo->start_date,
                'now'        => now(),
            ]);
            return false;
        }

        if ($promo->end_date && now()->gt($promo->end_date)) {
            Log::info('[PromotionValidator] Promotion has expired.', [
                'promo_id'   => $promo->id,
                'promo_name' => $promo->name,
                'end_date'   => $promo->end_date,
                'now'        => now(),
            ]);
            return false;
        }

        return true;
    }

    /**
     * Validate cart-related rules (quantity, amount, applies_to).
     */
    private function validateCart($promo, $cart): bool
    {
        if (!empty($promo->min_quantity) && $cart->total_quantity < $promo->min_quantity) {
            Log::info('[PromotionValidator] Cart quantity below minimum.', [
                'promo_id'      => $promo->id,
                'promo_name'    => $promo->name,
                'required'      => $promo->min_quantity,
                'cart_quantity' => $cart->total_quantity,
            ]);
            return false;
        }

        if (!empty($promo->min_amount) && $cart->subtotal < $promo->min_amount) {
            Log::info('[PromotionValidator] Cart subtotal below minimum amount.', [
                'promo_id'    => $promo->id,
                'promo_name'  => $promo->name,
                'required'    => $promo->min_amount,
                'subtotal'    => $cart->subtotal,
            ]);
            return false;
        }

        if (!empty($promo->applies_to) && $promo->applies_to !== 'both') {
            if ($cart->type !== 'both' && $promo->applies_to !== $cart->type) {
                Log::info('[PromotionValidator] Cart type does not match applies_to.', [
                    'promo_id'   => $promo->id,
                    'promo_name' => $promo->name,
                    'applies_to' => $promo->applies_to,
                    'cart_type'  => $cart->type,
                ]);
                return false;
            }
        }

        return true;
    }

    /**
     * Validate conditions (school_id, parent_id, etc.).
     * Conditions of the same type are OR'd; different types are AND'd.
     */
    private function validateConditions($promo, $user): bool
    {
        if ($promo->conditions->isEmpty()) {
            return true;
        }

        $groupedConditions = $promo->conditions->groupBy('condition_type');

        foreach ($groupedConditions as $type => $conditions) {
            $allowedValues = $conditions->pluck('condition_value')->toArray();

            switch ($type) {
                case 'school_id':
                    if (!isset($user->school_id) || !in_array($user->school_id, $allowedValues)) {
                        Log::info('[PromotionValidator] school_id condition failed.', [
                            'promo_id'     => $promo->id,
                            'promo_name'   => $promo->name,
                            'user_school'  => $user->school_id ?? null,
                            'allowed'      => $allowedValues,
                        ]);
                        return false;
                    }
                    break;

                case 'parent_id':
                    if (!isset($user->id) || !in_array($user->id, $allowedValues)) {
                        Log::info('[PromotionValidator] parent_id condition failed.', [
                            'promo_id'   => $promo->id,
                            'promo_name' => $promo->name,
                            'user_id'    => $user->id ?? null,
                            'allowed'    => $allowedValues,
                        ]);
                        return false;
                    }
                    break;

                // Future-safe: ignore unknown condition types
                default:
                    Log::warning('[PromotionValidator] Unknown condition type — ignored.', [
                        'promo_id'       => $promo->id,
                        'condition_type' => $type,
                    ]);
                    continue 2;
            }
        }

        return true;
    }
}