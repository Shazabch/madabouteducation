<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductVariation;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class VariationManagement extends Component
{
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public ProductVariation $productVariation;
    public Product $product;
    public $editableMode = false;
    public $newImage;

    protected $rules = [
        'productVariation.title' => 'required',
        'productVariation.image' => 'nullable',
        'newImage' => 'nullable',

    ];

    public function mount()
    {
        $this->productVariation = new ProductVariation();
    }

    public function createOrEdit($id = null)
    {
        if ($id) {
            $this->productVariation = ProductVariation::find($id);
        } else {
            $this->productVariation = new ProductVariation();
        }
        $this->editableMode = true;
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
    }

    public function save()
    {
        $this->validate();
        $this->productVariation->product_id=$this->product->id;
        if (!empty($this->newImage)) {
            $oldImage=$this->productVariation->image;
            #move image to property folder
            $saved_image_path = 'storage/' . $this->newImage->store('products-variations', 'public');
            #save image path to db
            $this->productVariation->image=$saved_image_path;
            $this->newImage=null;
            deleteFile($oldImage);
        }
        $this->productVariation->save();
        $this->editableMode = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'ProductVariation saved successfully.']);
    }

    public function delete($id)
    {
        ProductVariation::destroy($id);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'ProductVariation deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.variation-management', ['productVariations' => $this->product->variations()->latest()->paginate(10)]);
    }
}
