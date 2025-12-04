<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_url',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function basketItems(): HasMany
    {
        return $this->hasMany(BasketItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


}
