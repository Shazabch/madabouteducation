<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductSubscription;
use Livewire\Component;
use Livewire\WithPagination;

class ShopSubscriptionsComponent extends Component
{
    use WithPagination;
    public $subscriptions = [];
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->subscriptions = ProductSubscription::where('status', 'active')->get();
    }
    public function render()
    {
        return view('livewire.admin.shop-subscriptions-component');
    }
}
