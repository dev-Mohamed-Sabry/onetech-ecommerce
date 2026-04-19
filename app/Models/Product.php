<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'base_price', 'discount_type', 'discount_value', 'quantity', 'description', 'image', 'final_price'];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}