<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'name' => 'required|string|min:3|max:255',
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

        // لو مفيش خصم نخلي القيمة صفر
        if ($discountType === 'none') {
            $discountValue = 0;
        }

        // ========================
        // 🔹 Calculate Final Price
        // ========================
        $finalPrice = $basePrice;
        \Log::emergency($discountType);
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
            'description' => $request->description,
            'image' => $imageName,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'data' => true,
            'message' => 'Product added successfully'
        ]);
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
    public function destroy(string $id)
    {
        //
    }
}
