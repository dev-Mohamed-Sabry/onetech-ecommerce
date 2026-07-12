<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'is_featured', 'quantity', 'category_id', 'image', 'base_price', 'discount_type', 'discount_value', 'final_price'];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function getImageAttribute($image)
    {
        return asset('uploads/products/' . $image);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
