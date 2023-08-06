<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminOrder extends Model
{
    public int $cols = 5;

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
