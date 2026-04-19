<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;
use Yajra\DataTables\DataTables;

use function Pest\Laravel\json;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category')->select(
                'id',
                'name',
                'description',
                'quantity',
                'image',
                'base_price',
                'discount_value',
                'final_price',
                'category_id',
            );
            return DataTables::of($products)

                ->addColumn('category', function ($product) {

                    return $product->category->name ?? '-';
                })

                ->editColumn('image', function ($product) {
                    if (!$product->image) return '-';
                    return ' <img src="/uploads/products/' . $product->image . '" width="60"> ';
                })

                ->editColumn('description', function ($product) {
                    return Str::limit(strip_tags($product->description), 25);
                })

                ->addColumn('action', function ($product) {
                    return
                        ' <div class="d-flex text-center" style="gap:2px;">
                            <button  class="btn btn-info edit-product " style="cursor:pointer;" data-id="' . $product->id . '" data-name="' . $product->name . '">Update</button>
                            <button  class="btn btn-danger delete-product " style="cursor:pointer;" data-id="' . $product->id . '">Delete</button>
                        </div> ';;
                })

                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('Dashboard.Products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $categories = Category::all('id', 'name');
        return view('Dashboard.Products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'base_price' => 'required|numeric|min:0',
            'discount_type' => 'nullable|in:none,percent,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string|min:10|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // ========================
        // 🔹 Prepare Data
        // ========================
        $basePrice = (float) $request->base_price;
        $discountType = $request->discount_type;

        $discountValue = (float) ($request->discount_value ?? 0);
        // dd($discountValue);
        // لو مفيش خصم نخلي القيمة صفر
        if ($discountType === 'none') {
            $discountValue = 0;
        }

        // ========================
        // 🔹 Calculate Final Price
        // ========================
        $finalPrice = $basePrice;

        // dd();
        if ($discountType === 'percent') {
            // حماية: النسبة متعديش 100%
            $discountValue = min($discountValue, 100);

            $finalPrice = $basePrice - ($basePrice * $discountValue / 100);
        } elseif ($discountType === 'fixed') {
            $finalPrice = $basePrice - $discountValue;
        }

        // حماية من السعر السالب
        $finalPrice = max(0, $finalPrice);

        // ========================
        // 🔹 Store Image
        // ========================
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/products'), $imageName);
        }

        // ========================
        // 🔹 Save Product
        // ========================

        Product::create([
            'name' => $request->name,
            'base_price' => $basePrice,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'quantity' => $request->quantity,
            'description' => Purifier::clean($request->description),
            'image' => $imageName,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'data' => true,
            'message' => 'Product added successfully'
        ]);

        // return response()->json([
        //     'data' => $request->all()
        // ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    { {
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Product Deleted successfully'
            ]);
        }
    }
}
