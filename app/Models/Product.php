<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imageUrl',
        'price',
        'category',
        'description',
        'is_available',
    ];

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'product_topping');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
