<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckStartDateRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (request()->date('startDate')->isPast() && ! request()->date('startDate')->isToday()) {
            $fail('back.invalid-startDate-value-in-past')->translate();
        }
    }
}
