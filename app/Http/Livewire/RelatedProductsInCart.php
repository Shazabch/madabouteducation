<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class RelatedProductsInCart extends Component
{
    public $alreadyAddedToCart = [];

    public function render()
    {
        $products = Product::whereNotIn('id', $this->alreadyAddedToCart)->where('status', true)->get();
        return view('livewire.related-products-in-cart', compact('products'));
    }
}
