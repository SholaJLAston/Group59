<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'description',
        'category_id',
        'image',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'price' => 'decimal:2',
    ];
}
