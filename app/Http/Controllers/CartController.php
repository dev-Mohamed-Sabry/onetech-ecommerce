<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\RecentlyViewedService;

class CartController extends Controller
{
    public function index(CartService $cartService)
    {
        return
            response()->json(
                [
                    'success' => true,
                    'cart' => $cartService->get(),
                    'total' => $cartService->total(),
                ]
            );
    }

    public function view(CartService $cartService, RecentlyViewedService $recentlyViewed)
    {

        $recentlyViewedProducts = $recentlyViewed->get();

        $products = Product::with('category')
            ->latest()
            ->get();

        $categories = Category::all('id', 'name');
        return view(
            'frontend.cart.view',
            [
                'products' => $products,
                'categories' => $categories,
                'recentlyViewedProducts' => $recentlyViewedProducts,
                'cart' => $cartService->get(),
                'total' => $cartService->total(),
            ]
        );
    }

    public function add(Request $request, CartService $cartService)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $cartService->add(
            $request->product_id,
            $request->quantity ?? 1
        );

        return response()->json([
            'success' => true,
            'cart' => $cartService->get(),
            'total' => $cartService->total(),
            'message' => 'Added to cart successfully',
        ]);
    }

    public function update(Request $request, CartService $cartService)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $result = $cartService->update(
            $request->product_id,
            $request->quantity
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'cart' => $cartService->get(),
            'total' => $cartService->total(),
        ]);
    }
}