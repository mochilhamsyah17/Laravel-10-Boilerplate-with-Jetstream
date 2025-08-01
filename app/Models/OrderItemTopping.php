<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemTopping extends Model
{
    use HasFactory;

    protected $table = 'order_item_toppings';

    protected $fillable = [
        'order_item_id',
        'topping_id',
        'quantity',
        'price',
        'created_at',
        'updated_at',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function topping()
    {
        return $this->belongsTo(Topping::class);
    }
}
