<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    public function index(CartService $cartService)
    {
        return response()->json([
            'success' => true,
            'cart' => $cartService->get(),
            'total' => $cartService->total(),
        ]);
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

        $cartService->update(
            $request->product_id,
            $request->quantity
        );

        return response()->json([
            'success' => true,
            'cart' => $cartService->get(),
            'total' => $cartService->total(),
        ]);
    }
}
