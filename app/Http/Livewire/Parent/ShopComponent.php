<?php

namespace App\Http\Livewire\Parent;

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedCategory = null;
    public $sortBy = 'latest';
    public $categories;

    protected $queryString = [
        'selectedCategory' => ['except' => ''],
        'sortBy' => ['except' => 'latest']
    ];

    public function mount()
    {
        // Get the category from URL if present
        if (request()->has('category')) {
            $this->selectedCategory = request()->category;
        }

        // Load categories for filter
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = ProductCategory::withCount('products')
            ->where('status', true)
            ->get();
    }

    public function filterByCategory($categorySlug)
    {
        $this->selectedCategory = $categorySlug;
        $this->resetPage(); // Reset pagination when changing category
        $this->loadCategories();
    }

    public function sortProducts($sort)
    {
        $this->sortBy = $sort;
        $this->resetPage(); // Reset pagination when changing sort
        $this->loadCategories();
    }

    public function render()
    {
        $query = Product::with(['category', 'images'])
            ->where('status', true);

        // Apply category filter
        if ($this->selectedCategory) {
            $category = ProductCategory::where('slug', $this->selectedCategory)
                ->where('status', true)
                ->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'price_low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        $this->loadCategories();
        $products = $query->paginate(12);

        return view('livewire.parent.shop-component', [
            'products' => $products
        ]);
    }
}
