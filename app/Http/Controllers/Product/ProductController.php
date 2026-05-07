<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;
use Yajra\DataTables\DataTables;

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
                'is_featured',
                'quantity',
                'image',
                'base_price',
                'discount_value',
                'final_price',
                'category_id',
            );
            // ->orderByDesc('is_featured');

            return DataTables::of($products)

                ->addColumn('category', function ($product) {

                    return $product->category->name ?? '-';
                })

                ->addColumn('featured_status', function ($product) {
                    return $product->is_featured
                        ? '<span class="text-success">🟢 Featured</span>'
                        : '<span class="text-secondary">🔴 Normal</span>';
                })

                ->editColumn('image', function ($product) {
                    if (!$product->image) return ' <img src="/uploads/products/no_img.jpg" width="70" height="70">';
                    return ' <img src="/uploads/products/' . $product->image . '" width="70" height="70">';
                })

                ->editColumn('description', function ($product) {

                    return Str::limit(strip_tags($product->description), 15);
                })

                ->addColumn('action', function ($product) {
                    return ' <div class="d-flex justify-content-center" style="gap:2px;">
                                <a href="' . route('products.edit', $product->id) . '" 
                                    class="btn btn-info edit-product" style="cursor:pointer;"> Edit </a>

                                    <button class="btn btn-danger delete-product" style="cursor:pointer;" data-id="' . $product->id . '"> 
                                        Delete
                                    </button>
                                </div>
                            ';
                })

                ->rawColumns(['action', 'image', 'featured_status'])
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
            'name' => 'required|string|min:2|max:255|unique:products',
            'base_price' => 'required|numeric|min:0',
            'discount_type' => 'required|in:none,percent,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string|min:10|max:2000',
            'is_featured' => 'required|min:0|max:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',

        ]);

        // ========================
        // 🔹 Prepare Data
        // ========================
        $basePrice = (float) $request->base_price;
        $discountType = $request->discount_type ?? 'none';

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
            'is_featured' => (bool) $request->is_featured,
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'base_price' => 'required|numeric|min:0',
            'discount_type' => 'required|in:none,percent,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string|min:10|max:2000',
            'is_featured' => 'required|min:0|max:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // 'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        };

        // ========================
        // 🔹 Prepare Data
        // ========================
        $basePrice = (float) $request->base_price;
        $discountType = $request->discount_type;
        $discountValue = (float) ($request->discount_value ?? 0);
        // لو مفيش خصم نخلي القيمة صفر
        if ($discountType === 'none') {
            $discountValue = 0;
        }

        // ========================
        // 🔹 Calculate Final Price
        // ========================
        $finalPrice = $basePrice;

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
        $imageName = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
        }

        // ========================
        // 🔹 Save Product
        // ========================

        $product->update([
            'name' => $request->name,
            'base_price' => $basePrice,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'quantity' => $request->quantity,
            'description' => Purifier::clean($request->description),
            'is_featured' => (bool) $request->is_featured,
            'image' => $imageName ?? $product->image,
            // 'category_id' => $request->category_id,
        ]);

        return response()->json([
            'data' => true,
            'message' => 'Product Updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    { {
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            $product->delete();
            return response()->json([
                'status' => 'success',
            ]);
        }
    }


    public function deleteProductImage(Product $product)
    {
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        $product->update([
            'image' => null
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
