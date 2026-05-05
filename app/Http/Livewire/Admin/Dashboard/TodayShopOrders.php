<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Enums\PaymentStatus;
use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class TodayShopOrders extends Component
{
    public $paymentStatus=PaymentStatus::Paid;
    public $totalOrders=0;
    public $totalSales=0;

    public function getOrders(){
       
    }
    public function render()
    {
        $query=Order::getOrdersByDateQuery(Carbon::today()->startOfDay(),null,$this->paymentStatus);
        $this->totalOrders=$query->count();
        $this->totalSales=$query->sum('net_total');
        $orders=$query->latest()->paginate('5');
        return view('livewire.admin.dashboard.today-shop-orders',compact('orders'));
    }
}
