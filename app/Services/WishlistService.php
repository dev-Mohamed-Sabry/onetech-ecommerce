<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Wishlist;

class WishlistService
{

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
        return Wishlist::with('product')
            ->where($this->key(), $this->value())
            ->get();
    }


    public function count()
    {
        return Wishlist::where(
            $this->key(),
            $this->value()
        )->count();
    }

    public function add($productId)
    {
        Wishlist::firstOrCreate([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ]);
    }

    public function remove($productId)
    {
        Wishlist::where([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ])->delete();
    }

    public function exists($productId)
    {
        return Wishlist::where([
            $this->key() => $this->value(),
            'product_id' => $productId,
        ])->exists();
    }
}