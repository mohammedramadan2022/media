<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MapUrlRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! str($value)->contains(['goo.gl/maps', 'maps'])) {
            $fail('back.invalid-map-url')->translate();
        }
    }
}
