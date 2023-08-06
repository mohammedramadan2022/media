<?php

namespace App\Http\Traits\Other;

use App\Models\Token;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasJwt
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function token(): MorphOne
    {
        return $this->morphOne(Token::class,'tokenable');
    }
}
