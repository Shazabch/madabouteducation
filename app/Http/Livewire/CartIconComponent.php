<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartIconComponent extends Component
{
    public $productsCount = 0;

    protected function getListeners()
    {
        return [
            'productAdded' => 'refreshProducts',
            'productRemoved' => 'refreshProducts',
            'productUpdated' => 'refreshProducts',

        ];
    }

    public function refreshProducts()
    {
        $cart = session('cart',[]);
        if ($cart) {
            $this->productsCount = count($cart);
        } else {
            $this->productsCount = 0;
        }
        $cartPrograms = session('cart_programs',[]);
        if ($cartPrograms) {
            $this->productsCount = $this->productsCount+count($cartPrograms);
        }
    }

    public function render()
    {
        return view('livewire.cart-icon-component');
    }
}
