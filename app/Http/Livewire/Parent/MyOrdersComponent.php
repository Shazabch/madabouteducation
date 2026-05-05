<?php

namespace App\Http\Livewire\Parent;

use App\Models\Order;
use Livewire\Component;

class MyOrdersComponent extends Component
{
    public $orders = [];
    public $selectedOrderId;
    public $selectedOrder;

    protected $queryString = [
        'selectedOrderId' => ['except' => ''],
    ];

    public function mount()
    {
        $this->orders = auth()->user()->orders;
        if ($this->selectedOrderId) {
            $this->orderDetails($this->selectedOrderId);
        }
    }

    public function delete($id)
    {
        Order::destroy($id);
        $this->orders = auth()->user()->orders;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Order has been deleted!']);
    }

    public function orderDetails($id)
    {
        $this->selectedOrderId = $id;
        $this->selectedOrder = Order::find($id);
    }

    public function close()
    {
        $this->selectedOrderId = null;
        $this->selectedOrder = null;
    }

    public function render()
    {
        return view('livewire.parent.my-orders-component');
    }
}
