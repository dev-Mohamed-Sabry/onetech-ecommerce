<?php

namespace App\Services;

use App\Models\RecentlyViewedProduct;

class RecentlyViewedService
{
    private function key()
    {
        return auth()->check() ? 'user_id' : 'session_id';
    }

    private function value()
    {
        return auth()->check() ? auth()->id() : session()->getId();
    }

    public function track($productId)
    {
        RecentlyViewedProduct::updateOrCreate(
            [
                $this->key() => $this->value(),
                'product_id' => $productId,
            ],
            [
                'last_viewed_at' => now(),
            ]
        );
    }

    public function get($limit = 10)
    {
        return RecentlyViewedProduct::with('product')
            ->where($this->key(), $this->value())
            ->orderByDesc('last_viewed_at')
            ->take($limit)
            ->get();
    }
}
