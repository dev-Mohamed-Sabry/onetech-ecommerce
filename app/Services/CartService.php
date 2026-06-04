<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    /**
     * Create a new class instance.
     */
    private function key()
    {
        return auth()->check() ? 'user_id' : 'guest_token';
    }

    private function value()
    {
        return auth()->check() ? auth()->id() : $this->guestToken();
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
                return $item->product->final_price * $item->quantity;
            });
    }

    public function add($productId, $quantity = 0)
    {
        $cart = Cart::firstOrNew([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ]);

        $cart->quantity += $quantity;
        $cart->save();
    }

    public function update($productId, $quantity)
    {
        $cart = Cart::where([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ])->first();

        if (!$cart) return;

        if ($quantity <= 0) {
            $cart->delete();
            return;
        }

        $cart->update([
            'quantity' => $quantity
        ]);
    }
}
