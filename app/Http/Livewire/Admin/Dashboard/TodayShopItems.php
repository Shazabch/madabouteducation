<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Enums\PaymentStatus;
use App\Models\OrderItem;
use Carbon\Carbon;
use Livewire\Component;

class TodayShopItems extends Component
{
    public function render()
    {
        $item_groups=OrderItem::with('product')->whereHas('order',function($q){
            $q->where('payment_status',PaymentStatus::Paid)->whereDate('created_at','>=',Carbon::today()->startOfDay());
        })->get()->groupBy('product_id');
        return view('livewire.admin.dashboard.today-shop-items',compact('item_groups'));
    }
}
