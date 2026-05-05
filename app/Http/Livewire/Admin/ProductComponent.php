<?php

namespace App\Http\Livewire\Admin;

use App\Models\Images;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProductComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public Product $product;
    public $subscriptionPrices = [
        '1_month' => null,
        '6_months' => null,
        '12_months' => null,
    ];
    public $images = [];
    public $mainImage;
    public $editableMode = false;

    protected $rules = [
        'subscriptionPrices.1_month' => 'nullable|numeric|min:0',
        'subscriptionPrices.6_months' => 'nullable|numeric|min:0',
        'subscriptionPrices.12_months' => 'nullable|numeric|min:0',
        'product.is_subscription' => 'nullable',
        'product.title' => 'required',
        'product.price' => 'required|numeric',
        'product.short_description' => 'nullable',
        'product.description' => 'nullable',
        'product.sku' => 'nullable',
        'product.additional_information' => 'nullable',
        'product.main_image' => 'nullable',
        'product.slug' => 'required',
        'product.meta_title' => 'nullable',
        'product.meta_description' => 'nullable',
        'product.meta_keywords' => 'nullable',
        'product.status' => 'nullable',
    ];

    public function mount(Product $product = null)
    {

        if ($product) {
            // If a product is passed, initialize it with the product data
            $this->product = $product;
            $this->subscriptionPrices = [
                '1_month' => $product->subscription_prices['1_month'] ?? null,
                '6_months' => $product->subscription_prices['6_months'] ?? null,
                '12_months' => $product->subscription_prices['12_months'] ?? null,
            ];
        } else {
            // Otherwise, create a new instance of Product with initial values
            $this->product = new Product([
                'price' => '0',
                'is_subscription' => false,
            ]);
        }
    }

    public function updatedProductTitle($title)
    {
        $this->product->slug = Str::slug($title);
    }


    public function createOrEdit($id = null)
    {
        if ($id) {
            $this->product = Product::find($id);
        } else {
            $this->product = new Product(['price' => '0']);
        }
        $this->editableMode = true;
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
    }

    public function save()
    {
        $this->product->status = $this->product->status ? true : false;
        $this->validate();
        $this->product->is_subscription = $this->product['is_subscription'] ? true : false;
        $this->product->subscription_prices = $this->product['is_subscription'] ? $this->subscriptionPrices : null;
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                #move image to property folder
                $saved_image_path = 'storage/' . $image->store('products', 'public');
                #save image path to db
                $this->product->images()->save(new Images([
                    'path' => $saved_image_path,
                ]));
            }
            $this->images = [];
        }
        if (!empty($this->mainImage)) {
            #move image to property folder
            $saved_image_path = 'storage/' . $this->mainImage->store('products', 'public');
            #save image path to db
            $this->product->main_image = $saved_image_path;
            $this->mainImage = null;
        }
        $this->product->save();
        $this->editableMode = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Product saved successfully.']);
    }

    public function delete($id)
    {
        Product::destroy($id);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Product deleted successfully.']);
    }

    public function removePhoto($id)
    {

        $photo = Images::find($id);
        if ($photo) {
            #delete photo
            deleteFile($photo->image_name);
            $photo->delete();
            $this->product->load('images');
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Image Removed Successfully']);
        }
    }

    public function removeMainPhoto()
    {
        deleteFile($this->product->main_image);
        $this->product->main_image = null;
    }

    public function render()
    {
        return view('livewire.admin.product-component', ['products' => Product::withCount('variations')->latest()->paginate(10)]);
    }
}
