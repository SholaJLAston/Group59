<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'description',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'price' => 'decimal:2',
    ];
}
