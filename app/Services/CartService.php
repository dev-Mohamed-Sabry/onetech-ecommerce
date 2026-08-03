<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class CartService
{
    /**
     * Create a new class instance.
     */
    private function key()
    {
        return Auth::check() ? 'user_id' : 'guest_token';
    }

    private function value()
    {
        return Auth::check() ? Auth::id() : $this->guestToken();
    }

    private function guestToken()
    {
        // 1. لو موجودة بالفعل في الكوكي
        if (request()->cookie('guest_token')) {
            return request()->cookie('guest_token');
        }

        // 2. لو مش موجودة، ننشئ واحدة جديدة
        $token = (string) Str::uuid();

        // 3. نخزنها لمدة سنة (60 * 24 * 365 دقيقة)
        Cookie::queue('guest_token', $token, 60 * 24 * 365);

        return $token;
    }

    public function get()
    {
        return Cart::with('product')
            ->where($this->key(), $this->value())
            ->get();
    }

    public function total()
    {
        return Cart::with('product')
            ->where($this->key(), $this->value())
            ->get()
            ->sum(function ($item) {
                return $item->product->final_price * $item->quantity ?? 0;
            });
    }

    public function add($productId, $quantity = 1)
    {
        $cart = Cart::firstOrNew([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ]);

        $cart->quantity = ($cart->exists ? $cart->quantity : 0) + $quantity;

        $cart->save();
    }


    public function update($productId, $quantity)
    {
        $cart = Cart::where([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ])->first();

        if (!$cart)  return [
            'success' => false,
            'message' => 'Cart item not found.',
        ];;

        if ($quantity <= 0) {
            $cart->delete();

            return [
                'success' => true,
            ];
        }

        $product = Product::findOrFail($productId);

        if ($quantity > $product->quantity) {
            return [
                'success' => false,
                'message' => 'Available stock is only ' . $product->quantity,
            ];
        }

        $cart->update([
            'quantity' => $quantity
        ]);
        return [
            'success' => true
        ];
    }

    public function clear()
    {
        Cart::where(
            $this->key(),
            $this->value()
        )->delete();
    }

    public function mergeGuestCartToUser($userId)
    {
        $guestToken = request()->cookie('guest_token');

        if (!$guestToken) {
            return;
        }

        $guestItems = Cart::where('guest_token', $guestToken)->get();

        foreach ($guestItems as $guestItem) {

            $userCart = Cart::where([
                'user_id' => $userId,
                'product_id' => $guestItem->product_id,
            ])->first();

            if ($userCart) {

                $userCart->increment(
                    'quantity',
                    $guestItem->quantity
                );

                $guestItem->delete();
            } else {

                $guestItem->update([
                    'user_id' => $userId,
                    'guest_token' => null,
                ]);
            }
        }
    }
}
