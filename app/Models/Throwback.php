<?php

namespace App\Models;

use App\Http\Traits\ThrowbackTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Throwback extends Model
{
    use ThrowbackTrait;

    public int $cols = 5;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
