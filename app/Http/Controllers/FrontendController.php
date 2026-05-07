<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\json;

class FrontendController extends Controller
{

    private function categories()
    {
        return Category::orderBy('order', 'asc')->get();
    }

    public function index()
    {
        // $categories = Category::select('name', 'order')->orderBy('order', 'asc')->get();
        return view('Frontend.index', ['categories' => $this->categories()]);
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
