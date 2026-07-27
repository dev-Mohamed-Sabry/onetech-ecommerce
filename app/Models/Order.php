<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'governorate',
        'city',
        'address',
        'notes',
        'payment_method',
        'total',
        'status',
        'order_number',
        'paymob_order_id',
        'paymob_transaction_id',
        'created_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
