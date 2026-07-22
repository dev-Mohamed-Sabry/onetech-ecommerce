<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $total = $cartService->total();

        return view('frontend.checkout.index', compact(
            'cart',
            'total',
            'categories',
        ));
    }

    public function placeOrder(Request $request, CartService $cartService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'governorate' => 'required',
            'city' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        $cart = $cartService->get();
        $total = $cartService->total();

        if ($cart->isEmpty()) {
            return redirect()
                ->route('cart.view')
                ->with('error', 'Your cart is empty.');
        }


        DB::transaction(function () use ($request, $cartService, $cart, $total) {

            $order = Order::create([
                'user_id' => auth()->user()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'governorate' => $request->governorate,
                'city' => $request->city,
                'address' => $request->address,
                'notes' => $request->note,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->final_price,
                    'item_total' => $item->product->final_price * $item->quantity,
                ]);
            }

            $cartService->clear();
        });

        $msg = "Order placed successfully. Total Cost: {$total} EGP. Thank you for shopping with us ♥";

        return redirect()
            ->route('home')
            ->with('success', $msg);
    }
}
