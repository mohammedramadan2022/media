<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class MobilePhoneRule implements ValidationRule
{
    private static function getNeedle(): string
    {
        return request('country_code','966') == '020' ? '1' : '5';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Str::startsWith($value, $this->getNeedle())) {
            $fail('api.phone_start_with_var')->translate(['var' => $this->getNeedle()]);
        }
    }
}
