<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordMinRule implements ValidationRule
{
    public function __construct(public $min) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(strlen($value) < $this->min) $fail('api.password-min')->translate();
    }
}
