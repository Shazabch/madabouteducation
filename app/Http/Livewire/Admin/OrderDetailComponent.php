<?php

namespace App\Http\Livewire\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OrderDetailComponent extends Component
{
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public Order $order;
    public  $orderStatuses=[];

    protected $rules=[
        'order.order_status'=>'required'
    ];

    public function save()
    {
        $this->validate();
        if($this->order->canChangeStatus()){
            $this->order->save();
            $this->dispatchBrowserEvent('success-notification',['message'=>'Order Updated Successfully']);
        }
    }

    public function render()
    {
        $this->orderStatuses=OrderStatus::getInstances();
        return view('livewire.admin.order-detail-component');
    }
}
