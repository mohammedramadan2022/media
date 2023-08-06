<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckEndDateRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(request()->date('startDate')->isFuture() && request()->date('endDate')->isToday()){
            $fail('back.invalid-endDate-value-in-future')->translate();
        }

        if (request()->date('endDate')->isPast() && !request()->date('endDate')->isToday()) {
            $fail('back.invalid-endDate-value-in-past')->translate();
        }
    }
}
