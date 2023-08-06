<?php

namespace App\Models;

use App\Http\Traits\PaymentTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use SoftDeletes, PaymentTrait;

    public int $cols = 5;

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }
}
