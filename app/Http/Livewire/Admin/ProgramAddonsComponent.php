<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Program;
use App\Models\Product;

class ProgramAddonsComponent extends Component
{
    public $programId;
    public $program;
    public $products=[];
    public $selectedProducts=[];


    public function mount()
    {
        $this->getProgram();
    }

    public function getAfterInit()
    {
        $this->getProducts();
        $this->getSelectedProducts();
    }

    public function getProgram(){
        $this->program=Program::find($this->programId);
    }

    public function getProducts()
    {
        $this->products=Product::all();
    }

    public function getSelectedProducts()
    {
        $this->selectedProducts=array_values($this->program->products->pluck('id')->toArray());
    }

    public function save()
    {
        $this->program->products()->sync($this->selectedProducts);
        $this->program->load('products');
        $this->getSelectedProducts();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Saved Successfully']);
    }


    public function render()
    {
        return view('livewire.admin.program-addons-component');
    }
}
