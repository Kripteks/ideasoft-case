<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'category' => 'integer'
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
