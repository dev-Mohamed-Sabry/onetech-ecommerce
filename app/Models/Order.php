<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orders()
    {
        return $this->hasMany(Product::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
