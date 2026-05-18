<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{

    private function categories()
    {
        return Category::orderBy('order', 'asc')->get();
    }

    public function index()
    {
        $identifierColumn = auth()->check()
            ? 'user_id'
            : 'session_id';

        $identifierValue = auth()->check()
            ? auth()->id()
            : session()->getId();

        $recentlyViewedProducts = RecentlyViewedProduct::with([
            'product:id,name,image,base_price,final_price,discount_type,discount_value,created_at'
        ])
            ->where($identifierColumn, $identifierValue)
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();

        $product_by_category = Product::first();

        $bannerProduct = Product::where('is_featured', 1)
            ->latest()
            ->first();

        $products = Product::with('category')
            ->latest()
            ->get();

        $featuredProducts = Product::with('category')
            ->where('is_featured', 1)
            ->latest()
            ->get();

        $hotSaleProducts = Product::where('discount_value', '>', 0)
            ->latest()
            ->get();

        $products_deals_of_the_week = Product::latest()
            ->take(3)
            ->get();

        $laptopCategory_latest_products = Product::with('category')
            ->where('category_id', 2)
            ->latest()
            ->take(3)
            ->get();

        return view('Frontend.index', [
            'categories' => $this->categories(),
            'products' => $products,
            'featuredProducts' => $featuredProducts,
            'products_deals_of_the_week' => $products_deals_of_the_week,
            'laptopCategory_latest_products' => $laptopCategory_latest_products,
            'bannerProduct' => $bannerProduct,
            'product_by_category' => $product_by_category,
            'hotSaleProducts' => $hotSaleProducts,
            'recentlyViewedProducts' => $recentlyViewedProducts,
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

    public function product_details(Product $product)
    {
        $product->load('category');

        $identifierColumn = auth()->check()
            ? 'user_id'
            : 'session_id';

        $identifierValue = auth()->check()
            ? auth()->id()
            : session()->getId();

        RecentlyViewedProduct::updateOrCreate(
            [
                $identifierColumn => $identifierValue,
                'product_id' => $product->id,
            ],
            [
                'last_viewed_at' => now(),
            ]
        );

        $recentlyViewedProducts = RecentlyViewedProduct::with('product')
            ->where($identifierColumn, $identifierValue)
            ->orderByDesc('last_viewed_at')
            ->take(10)
            ->get();

        $categories = Category::all('id', 'name');

        return view(
            'Frontend.Products.view',
            [
                'recentlyViewedProducts' => $recentlyViewedProducts,
                'product' => $product,
                'categories' => $categories
            ]
        );
    }

    public function search_products(Request $request)
    {
        try {
            $product = $request->search;
            $products = Product::where('name', 'LIKE', "%{$product}%")
                ->select('id', 'name', 'image', 'final_price')->latest()->paginate(10);

            if ($products->isNotEmpty()) {
                return response()->json([
                    'success' => true,
                    'products' => $products
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
