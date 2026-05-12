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


        return $filtered;
    }

    /**
     * Master validation — all checks must pass.
     */
    private function isValid($promo, $cart, $user): bool
    {
        return
            $this->validateDate($promo) &&
            $this->validateMaxUses($promo) &&
            $this->validateMaxUsesPerUser($promo, $user) &&
            $this->validateCart($promo, $cart) &&
            $this->validateTriggers($promo, $cart) &&
            $this->validateConditions($promo, $user);
    }

    /**
     * Validate if promotion has not exceeded global max uses.
     */
    private function validateMaxUses($promo): bool
    {
        if (!$promo->max_uses) {
            return true; // No global limit set
        }

        try {
            $totalUsed = $promo->usages()->sum('used_count') ?? 0;

            if ($totalUsed >= $promo->max_uses) {
                Log::info('[PromotionValidator] Promotion has reached max uses.', [
                    'promo_id'   => $promo->id,
                    'promo_name' => $promo->name,
                    'max_uses'   => $promo->max_uses,
                    'total_used' => $totalUsed,
                ]);
                return false;
            }
        } catch (\Throwable $e) {
            Log::error('[PromotionValidator] Error checking max uses.', [
                'promo_id' => $promo->id,
                'error'    => $e->getMessage(),
            ]);
            return true; // Don't fail if check errors
        }

        return true;
    }

    /**
     * Validate if user has not exceeded per-user max uses.
     */
    private function validateMaxUsesPerUser($promo, $user): bool
    {
        if (!$promo->max_uses_per_user) {
            return true; // No per-user limit set
        }

        if (!$user || !$user->id) {
            Log::info('[PromotionValidator] No user logged in — skipping per-user max uses check.', [
                'promo_id' => $promo->id,
                'promo_name' => $promo->name,
            ]);
            return true; // No user logged in, allow to proceed
        }

        try {
            $userUsageCount = $promo->usages()
                ->where('user_id', $user->id)
                ->sum('used_count') ?? 0;

            if ($userUsageCount >= $promo->max_uses_per_user) {
                Log::info('[PromotionValidator] User has reached per-user max uses.', [
                    'promo_id' => $promo->id,
                    'promo_name' => $promo->name,
                    'user_id' => $user->id,
                    'max_uses_per_user' => $promo->max_uses_per_user,
                    'user_used_count' => $userUsageCount,
                ]);
                return false;
            }
        } catch (\Throwable $e) {
            Log::error('[PromotionValidator] Error checking per-user max uses.', [
                'promo_id' => $promo->id,
                'user_id'  => $user->id ?? 'unknown',
                'error'    => $e->getMessage(),
            ]);
            return true; // Don't fail if check errors
        }

        return true;
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
            // Log::info('[PromotionValidator] FREE GIFT — trigger required but not found in cart.', [
            //     'promo_id'   => $promo->id,
            //     'promo_name' => $promo->name,
            //     'triggers'   => $promo->gifts->map(fn($g) => [
            //         'trigger_program_id' => $g->trigger_program_id,
            //         'trigger_product_id' => $g->trigger_product_id,
            //     ])->toArray(),
            //     'cart_items' => $cart->items ?? [],
            // ]);
        }

        return $triggerFound;
    }

    /**
     * Validate date range.
     */
    private function validateDate($promo): bool
    {
        if ($promo->start_date && now()->lt($promo->start_date)) {
            Log::info('[PromotionValidator] Promotion not active yet.', [
                'promo_id'   => $promo->id,
                'promo_name' => $promo->name,
                'start_date' => $promo->start_date,
            ]);
            return false;
        }

        if ($promo->end_date && now()->gt($promo->end_date)) {
            Log::info('[PromotionValidator] Promotion expired.', [
                'promo_id'   => $promo->id,
                'promo_name' => $promo->name,
                'end_date'   => $promo->end_date,
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
        if (!empty($promo->min_amount) && $cart->subtotal < $promo->min_amount) {
            return false;
        }

        // Strict applies_to check:
        //
        //  cart type  │ applies_to = 'product' │ applies_to = 'program' │ applies_to = 'both'
        // ────────────┼────────────────────────┼────────────────────────┼─────────────────────
        //  product    │ ✅ pass                │ ❌ fail                 │ ✅ pass
        //  program    │ ❌ fail                │ ✅ pass                 │ ✅ pass
        //  both       │ ❌ fail                │ ❌ fail                 │ ✅ pass
        //
        // A mixed cart (both) only qualifies for promos explicitly set to 'both'.
        // A single-type cart qualifies for its own type OR 'both'.

        if (!empty($promo->applies_to)) {
            $cartType  = $cart->type;   // 'product' | 'program' | 'both'
            $appliesTo = $promo->applies_to;

            $passes = match ($appliesTo) {
                'both'    => true,                      // promo accepts any cart
                'product' => $cartType === 'product',   // promo only for pure-product carts
                'program' => $cartType === 'program',   // promo only for pure-program carts
                default   => false,
            };

            if (!$passes) {
                Log::info('[PromotionValidator] Promotion skipped — cart type mismatch.', [
                    'promo_id'   => $promo->id,
                    'promo_name' => $promo->name,
                    'applies_to' => $appliesTo,
                    'cart_type'  => $cartType,
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
                        return false;
                    }
                    break;

                case 'parent_id':
                    if (!isset($user->id) || !in_array($user->id, $allowedValues)) {
                        return false;
                    }
                    break;

                // Future-safe: ignore unknown condition types
                default:
                    continue 2;
            }
        }

        return true;
    }
}
