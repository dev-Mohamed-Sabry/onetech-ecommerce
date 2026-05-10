<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;


class FrontendController extends Controller
{

    private function categories()
    {
        return Category::orderBy('order', 'asc')->get();
    }

    public function index()
    {
        $product_by_category = Product::first();
        $featuredProducts = Product::where('is_featured', 1)->latest()->get();
        $products_deals_of_the_week = Product::latest()->take(3)->get();
        return view('Frontend.index', [
            'categories' => $this->categories(),
            'featuredProducts' => $featuredProducts,
            'products_deals_of_the_week' => $products_deals_of_the_week,
            'product_by_category' => $product_by_category,
        ]);
    }

    public function contact()
    {
        return view('Frontend.contact', ['categories' => $this->categories()]);
    }
    public function blog()
    {
        return view('Frontend.blog', ['categories' => $this->categories()]);
    }


    /*
|--------------------------------------------------------------------------
|Frontend Show Products
|--------------------------------------------------------------------------
*/
    public function products_by_category(Category $category)
    {
        $categories = Category::all('id', 'name');
        $products = $category->products()->latest()->paginate(10);
        return view('Frontend.Products.products-by-category', compact('categories', 'category', 'products'));
    }

    public function product_details(Product $product, Category $category)
    {
        $categories = Category::all('id', 'name');
        return view('Frontend.Products.view', compact('product', 'category', 'categories'));
    }
}
