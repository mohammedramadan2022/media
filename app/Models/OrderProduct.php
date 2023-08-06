<?php

namespace App\Models;

use App\Http\Traits\BasicTrait;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, Pivot};

class OrderProduct extends Pivot
{
    use BasicTrait;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
