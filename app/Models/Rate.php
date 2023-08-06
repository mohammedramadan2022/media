<?php

namespace App\Models;

use App\Http\Traits\RateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rate extends Model
{
    use RateTrait;

    public int $cols = 5;

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }
}
