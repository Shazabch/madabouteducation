<?php

namespace App\Http\Livewire\Parent;

use App\Models\ProgramOrder;
use Livewire\Component;

class BookedProgramsComponent extends Component
{
    public $orders = [];
    public $order;

    public function mount()
    {
        $this->getOrders();
    }

    public function orderDetails($id)
    {
        $this->order = ProgramOrder::find($id);
    }

    public function closeOrderDetails()
    {
        $this->order = null;
    }

    public function getOrders()
    {
        $this->orders = ProgramOrder::where('payment_status', 'paid')->where('user_id', auth()->id())->latest()->get();
    }
    public function render()
    {
        return view('livewire.parent.booked-programs-component');
    }
}
