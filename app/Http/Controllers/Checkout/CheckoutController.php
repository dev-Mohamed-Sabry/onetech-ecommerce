<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\PaymobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;

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

    public function placeOrder(Request $request, CartService $cartService, PaymobService $paymobService)
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

        $order = DB::transaction(function () use ($request,  $cart,  $total) {

            $status = $request->payment_method === 'cash_on_delivery'
                ? 'pending'
                : 'pending_payment';

            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'governorate' => $request->governorate,
                'city' => $request->city,
                'address' => $request->address,
                'notes' => $request->note,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'status' => $status,
            ]);


            $order->update([
                'order_number' => 'ONT-' .
                    $order->created_at->format('Ymd') .
                    '-' .
                    str_pad($order->id, 6, '0', STR_PAD_LEFT)
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



            return $order;
        });

        $order->load('items.product');
        Mail::to($order->email)
            ->queue(new OrderCreatedMail($order));

        /*
    |--------------------------------------------------------------------------
    | Cash On Delivery
    |--------------------------------------------------------------------------
    */

        if ($request->payment_method === 'cash_on_delivery') {

            $cartService->clear();

            return redirect()
                ->route('home')
                ->with(
                    'success',
                    "Order placed successfully. Total Cost: {$total} EGP. Thank you for shopping with us ♥"
                );
        }

        /*
    |--------------------------------------------------------------------------
    | Paymob
    |--------------------------------------------------------------------------
    */

        if ($request->payment_method === 'paymob') {

            $paymobOrderId = $paymobService->createOrder($order);

            // dd($paymobOrderId);

            $order->update([
                'paymob_order_id' => $paymobOrderId
            ]);

            // dd($paymobOrderId); // مؤقتًا للتأكد إنه رجع

            $paymentKey = $paymobService->getPaymentKey($order);

            $iframeUrl = $paymobService->getIframeUrl($paymentKey);

            return redirect($iframeUrl);
        }
    }
}