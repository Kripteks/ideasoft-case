<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'since',
        'revenue'
    ];

    protected $casts = [
        'since' => 'datetime',
        'revenue' => 'decimal:2'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
