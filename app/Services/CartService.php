<?php

namespace App\Services;

use App\Models\Cart;

class CartService
{
    /**
     * Create a new class instance.
     */
    private function key()
    {
        return auth()->check() ? 'user_id' : 'session_id';
    }

    private function value()
    {
        return auth()->check() ? auth()->id() : session()->getId();
    }

    public function add($productId, $quantity) {}
}