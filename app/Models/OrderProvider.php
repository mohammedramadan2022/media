<?php

namespace App\Models;

use App\Http\Traits\BasicTrait;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, Pivot};

class OrderProvider extends Pivot
{
    use BasicTrait;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
