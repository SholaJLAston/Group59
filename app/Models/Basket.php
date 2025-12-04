<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    protected $fillable = [
        'user_id',
    ];

        return $this->belongsTo(User::class);
    }

        return $this->hasMany(BasketItem::class);
    }
}
