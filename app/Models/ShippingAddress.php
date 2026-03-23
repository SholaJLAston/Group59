<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingAddress extends Model
{
    protected $fillable = [
        'order_id',
        'street_address',
        'city',
        'postal_code',
        'phone_number',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
