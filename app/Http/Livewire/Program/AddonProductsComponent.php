<?php

namespace App\Http\Livewire\Program;

use Livewire\Component;

class AddonProductsComponent extends Component
{
    public $program;

    public function loadProducts()
    {
        $this->program->load('products');
    }
    public function render()
    {
        return view('livewire.program.addon-products-component');
    }
}
