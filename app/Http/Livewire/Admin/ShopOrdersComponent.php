<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Enums\PaymentStatus;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShopOrdersComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $startDate;
    public $endDate;
    public $orderStatus;
    public $paymentStatus = PaymentStatus::Paid;
    public $filterByColumn = 'created_at';
    public $selected = [];
    public bool $selectAll = false;
    public bool $triggerSelectAll = false;

    protected $queryString = ['orderStatus', 'paymentStatus', 'filterByColumn'];

    public function updatingSelectAll($value)
    {
        $this->triggerSelectAll = true;
    }

    public function regenerateInvoice($id)
    {
        $order = Order::find($id);
        $order->generateInvoice();
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Invoice has been regenerated']);
    }

    public function render()
    {
        // if(!$this->startDate)
        // {
        //     $this->startDate=date("Y-m-d");
        // }

        // if(!$this->endDate)
        // {
        //     $this->endDate=date("Y-m-d");
        // }
        $query = Order::query()
            ->when($this->paymentStatus, function ($query, $paymentStatus) {
                return $query->where('payment_status', $paymentStatus);
            })
            ->when($this->orderStatus, function ($query, $orderStatus) {
                return $query->where('order_status', $orderStatus);
            })
            ->when($this->startDate, function ($query, $startDate) {
                return $query->whereDate($this->filterByColumn, '>=', $startDate);
            })
            ->when($this->endDate, function ($query, $endDate) {
                return $query->whereDate($this->filterByColumn, '<=', $endDate);
            });
        $total = $query->sum('net_total');
        $totalOrders = $query->count();
        $orders = $query->latest()->paginate('10');
        if ($this->triggerSelectAll) {
            if ($this->selectAll) {
                $this->selected = array_values($query->pluck('id')->toArray());
            } else {
                $this->selected = [];
            }
            $this->triggerSelectAll = false;
        }
        return view('livewire.admin.shop-orders-component', compact('total', 'orders', 'totalOrders'));
    }
}
