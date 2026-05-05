<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Enums\PaymentStatus;
use App\Models\ProgramOrder;
use Carbon\Carbon;
use Livewire\Component;

class TodayCampOrders extends Component
{
    public $paymentStatus=PaymentStatus::Paid;
    public $totalOrders=0;
    public $totalSales=0;
    
    public function render()
    {
        $query=ProgramOrder::getOrdersByDateQuery(Carbon::today()->startOfDay(),null,$this->paymentStatus);
        $this->totalOrders=$query->count();
        $this->totalSales=$query->sum('net_total');
        $orders=$query->latest()->paginate('5');
        return view('livewire.admin.dashboard.today-camp-orders',compact('orders'));
    }
}
