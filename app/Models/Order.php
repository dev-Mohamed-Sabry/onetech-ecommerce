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
    public function decreaseStock()
    {
        foreach ($this->items as $item) {

            $product = $item->product;

            if ($product->quantity < $item->quantity) {

                throw new \Exception(
                    "Insufficient stock for {$product->name}"
                );
            }

            $product->decrement(
                'quantity',
                $item->quantity
            );
        }
    }
}