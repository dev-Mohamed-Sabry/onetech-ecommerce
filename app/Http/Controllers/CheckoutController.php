<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {

        $categories = Category::all('id', 'name');

        $cart = $cartService->get();

        if ($cart->isEmpty()) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        $total = $cart->sum(function ($item) {
            return $item->product->final_price * $item->product->quantity;
        });

        return view('frontend.checkout.index', compact(
            'cart',
            'total',
            'categories',
        ));
    }
}