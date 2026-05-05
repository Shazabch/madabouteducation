<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductCategory;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ProductCategoryComponent extends Component
{
    use WithPagination, withFileUploads;

    protected $paginationTheme = 'bootstrap';

    public ProductCategory $category;
    public $categoryImage;
    public $editableMode = false;

    protected function rules()
    {
        return [
            'category.name' => 'required',
            'category.slug' => ['required', Rule::unique('product_categories', 'slug')->ignore($this->category->id)],
            'category.description' => 'nullable',
            'category.status' => 'nullable',
            'category.image' => 'nullable',
        ];
    }

    public function mount()
    {
        $this->category = new ProductCategory();
    }

    public function updatedCategoryName($name)
    {
        $this->category->slug = Str::slug($name);
    }

    public function createOrEdit($id = null)
    {
        if ($id) {
            $this->category = ProductCategory::find($id);
        } else {
            $this->category = new ProductCategory();
        }
        $this->editableMode = true;
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
    }

    public function save()
    {
        $this->category->status = $this->category->status ? true : false;
        $this->validate();

        if (!empty($this->categoryImage)) {
            // Delete old image if exists
            if ($this->category->image) {
                deleteFile($this->category->image);
            }

            // Store new image
            $saved_image_path = 'storage/' . $this->categoryImage->store('product-categories', 'public');
            $this->category->image = $saved_image_path;
            $this->categoryImage = null;
        }

        $this->category->save();
        $this->editableMode = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Category saved successfully.']);
    }

    public function removeCategoryImage()
    {
        if ($this->category->image) {
            deleteFile($this->category->image);
            $this->category->image = null;
            $this->category->save();
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Image removed successfully.']);
        }
    }

    public function delete($id)
    {
        ProductCategory::destroy($id);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Category deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.product-category-component', [
            'categories' => ProductCategory::withCount('products')->latest()->paginate(10)
        ]);
    }
}
