<?php

namespace App\Http\Livewire\Admin\Promotion;

use Livewire\Component;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // ── Summary cards ──────────────────────────────────────────────
    public $totalPromotions   = 0;
    public $activePromotions  = 0;
    public $expiredPromotions = 0;
    public $totalUsage        = 0;

    // ── Extra stats ────────────────────────────────────────────────
    public $totalDiscountGiven = 0;   // sum of fixed/percentage value × used_count
    public $typeBreakdown      = [];  // ['percentage' => 3, 'fixed' => 2, 'free_gift' => 1]
    public $topPromotions      = [];  // top 5 by usage
    public $expiringSoon       = [];  // active promos expiring within 7 days
    public $recentUsages       = [];  // last 10 usage records with user + promo info
    public $unusedPromotions   = 0;   // active promos with 0 uses

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // ── Summary ────────────────────────────────────────────────
        $this->totalPromotions = Promotion::count();

        $this->activePromotions = Promotion::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->count();

        $this->expiredPromotions = Promotion::whereNotNull('end_date')
            ->where('end_date', '<', now())
            ->count();

        $this->totalUsage = PromotionUsage::sum('used_count');

        // ── Type breakdown ─────────────────────────────────────────
        $this->typeBreakdown = Promotion::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // ── Top 5 promotions by usage ──────────────────────────────
        $this->topPromotions = Promotion::withSum('usages', 'used_count')
            ->orderByDesc('usages_sum_used_count')
            ->limit(5)
            ->get(['id', 'name', 'code', 'type', 'value', 'is_active', 'max_uses'])
            ->map(fn($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'code'      => $p->code ?? '—',
                'type'      => $p->type,
                'value'     => $p->value,
                'is_active' => $p->is_active,
                'max_uses'  => $p->max_uses,
                'used'      => $p->usages_sum_used_count ?? 0,
            ])
            ->toArray();

        // ── Promotions expiring within 7 days ──────────────────────
        $this->expiringSoon = Promotion::where('is_active', true)
            ->whereNotNull('end_date')
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', now()->addDays(7))
            ->orderBy('end_date')
            ->get(['id', 'name', 'code', 'end_date'])
            ->map(fn($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'code'     => $p->code ?? '—',
                'end_date' => $p->end_date->format('Y-m-d'),
                'days_left' => now()->diffInDays($p->end_date, false),
            ])
            ->toArray();

        // ── Unused active promotions ───────────────────────────────
        $usedPromoIds = PromotionUsage::where('used_count', '>', 0)
            ->pluck('promotion_id');

        $this->unusedPromotions = Promotion::where('is_active', true)
            ->whereNotIn('id', $usedPromoIds)
            ->count();

        // ── Recent 10 usages ───────────────────────────────────────
        $this->recentUsages = PromotionUsage::with(['promotion', 'user'])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(fn($u) => [
                'promo_name' => $u->promotion?->name ?? '—',
                'promo_code' => $u->promotion?->code ?? '—',
                'user_name'  => $u->user?->name ?? 'Guest',
                'used_count' => $u->used_count,
                'updated_at' => $u->updated_at->format('Y-m-d H:i'),
            ])
            ->toArray();

        // ── Total discount value given out ─────────────────────────
        // For fixed: sum(value × used_count). For percentage: we can only
        // estimate from the records we have — stored as metadata if available.
        // We sum fixed-type promotions as a concrete figure.
        $this->totalDiscountGiven = PromotionUsage::join('promotions', 'promotions.id', '=', 'promotion_usages.promotion_id')
            ->where('promotions.type', 'fixed')
            ->selectRaw('SUM(promotions.value * promotion_usages.used_count) as total')
            ->value('total') ?? 0;
    }

    public function render()
    {
        return view('livewire.admin.promotion.dashboard');
    }
}