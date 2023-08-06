<?php

namespace App\Rules;

use App\Facade\Support\Core\Regex;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsEn implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Regex::english($value)) {
            $fail('back.text-must-be-english')->translate();
        }
    }
}
