<?php

namespace App\Models;

use App\Http\Traits\FcmTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Fcm extends Model
{
    use FcmTrait;

    protected $guarded = ['id'];

    public function fcmable(): MorphTo
    {
        return $this->morphTo();
    }
}
