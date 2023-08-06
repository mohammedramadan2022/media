<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Status implements CastsAttributes
{
    public const ACTIVE = 1;
    
    public const DEDUCTIVE = 0;

    public function get($model, $key, $value, $attributes)
    {
        return $value;
    }

    public function set($model, $key, $value, $attributes): bool
    {
        return ! is_null($value) ? $value : false;
    }
}
