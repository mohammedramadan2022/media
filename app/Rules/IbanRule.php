<?php

namespace App\Rules;

use App\Facade\Support\Core\Regex;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IbanRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Regex::iban($value)) {
            $fail('back.the-iban-field-is-not-in-a-correct-form')->translate();
        }
    }
}
