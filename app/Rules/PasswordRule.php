<?php

namespace App\Rules;

use App\Facade\Support\Core\Regex;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Regex::password($value)) {
            $fail('api.password-must-contains-numbers')->translate();
        }
    }
}
