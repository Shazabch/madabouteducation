<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function categories()
    {
        $categories = ProductCategory::active()
            ->withCount(['products' => function ($query) {
                $query->where('status', 1); // or your condition, e.g. ->where('is_active', 1)
            }])
            ->get();
        return view('shop.categories', compact('categories'));
    }

    public function shop(Request $request)
    {
        $query = Product::active();

        if ($request->category) {
            $category = ProductCategory::where('slug', $request->category)->firstOrFail();
            $products = $category->products();
        }

        $products = $query->latest()->paginate(12);
        return view('shop.shop', compact('products'));
    }

    public function productDetail(Request $request, $slug)
    {
        $product = Product::with('variations')->where('slug', $slug)->active()->firstOrFail();
        return view('shop.product_detail', compact('product'));
    }

    public function cart()
    {
        return view('shop.cart');
    }

    public function checkoutDetails()
    {
        return view('shop.check-out-details');
    }
}
