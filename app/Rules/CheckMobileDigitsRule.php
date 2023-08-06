<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CheckMobileDigitsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Str::length($value) !== self::getNeedle()) {
            $fail('api.phone_digits_between')->translate(['num' => self::getNeedle()]);
        }
    }

    private static function getNeedle(): int
    {
        return request()->country_code == '966' ? 10 : 11;
    }
}
