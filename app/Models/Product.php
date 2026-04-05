<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'price', 'discount', 'quantity', 'description', 'image'];

    public function getFinalPriceAttribute()
    {
        if (!$this->discount || $this->discount == 0) {
            return $this->price;
        }

        return $this->price - ($this->price * $this->discount / 100);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
