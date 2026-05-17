<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewedProduct extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'last_viewed_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
