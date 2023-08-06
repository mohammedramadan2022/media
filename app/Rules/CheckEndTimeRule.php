<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckEndTimeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (request('diff') < 0 && request()->date('startDate')->isToday()) {
            $fail('back.invalid-end-time-rule')->translate();
        }

        if (request()->date('startTime')->diffInHours(request()->date('endTime')) == 0) {
            $fail('api.sorry-the-min-duration-to-renting-is-hour')->translate();
        }
    }
}
