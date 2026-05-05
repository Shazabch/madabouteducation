<?php

namespace App\Http\Livewire\Parent;

use Livewire\Component;

class AddToCartDetailComponent extends Component
{
    public $productId;
    public $product;
    public $count = 0;
    public $selectedVariation;
    public $selectedVariationImage;
    public $productInCart;
    public $subscriptionMonths;
    public $subscriptionPrice = 0;

    protected function getListeners()
    {
        return [
            'productAdded' => 'refreshCount',
            'productRemoved' => 'refreshCount',
            'productUpdated' => 'refreshCount',

        ];
    }

    public function updatedSubscriptionMonths($value)
    {
        if($value > 0)
        {

            $subscriptions = json_decode($this->product->subscription_prices, true);
            $this->subscriptionPrice = $subscriptions[$value == 1 ? $value.'_month' : $value.'_months'];
        }
        else{
            $this->subscriptionPrice = 0;
        }
    }
    public function updatedSelectedVariation()
    {
        if ($this->selectedVariation != 'default') {
            $this->selectedVariationImage = $this->selectedVariation ? $this->product->variations()->where('title', $this->selectedVariation)->first()->image : '';
        } else {
            $this->selectedVariationImage = '';
        }

        $this->refreshCount();
    }

    public function updatedCount($value)
    {
        if ($value == 0 || $value < 1) {
            $this->count = 0;
        }
    }

    public function mount()
    {
        $this->refreshCount();
    }

    public function AddToCart()
    {
         if ($this->product->variations->isNotEmpty()) {
        // If no variation is selected, show an error or return early
        if (!$this->selectedVariation) {

            $this->dispatchBrowserEvent('error-notification',['message'=>'Please select a variation.']);
            $this->addError('selectedVariation', 'Please select a variation.');
            return;
        }
    }
        $this->emitTo('parent.cart-component', 'add', $this->productId, $this->count, $this->selectedVariation ,  $this->subscriptionPrice , $this->subscriptionMonths);
    }

    public function removeFromCart()
    {
        $this->emitTo('parent.cart-component', 'add', $this->productId, 0, $this->selectedVariation);
        $this->selectedVariation = null;
    }

    public function refreshCount()
    {
        $variation = $this->selectedVariation == 'default' ? '' : $this->selectedVariation;
        $products = collect(session('cart'));
        $product = $products->filter(function ($item) use ($variation) {
            return $item['id'] == $this->productId && $item['variation'] == $variation;
        })->first();
        $this->productInCart = $product ? $product : [];
        $this->count = $product ? $product['quantity'] : 0;

        if ($product) {
            $this->selectedVariation = $product['variation'];
        }

        if ($this->selectedVariation != 'default') {
            $this->selectedVariationImage = $this->selectedVariation ? $this->product->variations()->where('title', $this->selectedVariation)->first()->image : '';
        } else {
            $this->selectedVariationImage = '';
        }
    }

    public function render()
    {
        return view('livewire.parent.add-to-cart-detail-component');
    }
}
