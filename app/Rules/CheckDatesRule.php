<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDatesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dates = explode(',', $value);

        $results = [];

        foreach ($dates as $key => $date) {
            if (! carbon()->parse($date)->isFuture()) {
                $results[$key] = false;
            }
        }

        if ((count($results) > 0)) {
            $fail('back.check-dates-rule')->translate();
        }
    }
}
