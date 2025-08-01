<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'notes',
        'price',
    ];

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'order_item_toppings')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
