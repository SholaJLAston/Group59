<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    protected $fillable = [
        'basket_id',
        'product_id',
        'quantity',
    ];

        return $this->belongsTo(Basket::class);
    }

        return $this->belongsTo(Product::class);
    }
}
