<?php

namespace App\Http\Livewire\Admin\Promotion;

use Livewire\Component;
use App\Models\Promotion;
use App\Models\PromotionUsage;

class Dashboard extends Component
{
    public $totalPromotions = 0;
    public $activePromotions = 0;
    public $expiredPromotions = 0;
    public $totalUsage = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
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
    }

    public function render()
    {
        return view('livewire.admin.promotion.dashboard');
    }
}
