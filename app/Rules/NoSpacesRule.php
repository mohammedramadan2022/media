<?php

namespace App\Rules;

use App\Facade\Support\Core\Regex;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoSpacesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Regex::noSpaces($value)) {
            $fail('api.text-must-not-have-a-spaces')->translate();
        }
    }
}
