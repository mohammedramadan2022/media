<?php

namespace App\Models;

use App\Http\Traits\BasicTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderAddress extends Model
{
    use BasicTrait;

    protected $guarded = ['id'];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
