<?php

namespace App\Models;

use App\Http\Traits\{BasicTrait, TokenTrait};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Token extends Model
{
    use TokenTrait, BasicTrait;

    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
}
