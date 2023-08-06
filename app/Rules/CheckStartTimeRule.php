<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckStartTimeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(request()->date('startDate')->isToday())
        {
            $now = head(explode(':', now()->format('H:i')));

            $current = head(explode(':', carbon()->parse($value)->format('H:i')));

            $diff = $current - $now;

            $_now = $now + 2;

            $morning = (int) $_now >= 12 ? trans('back.post-morning') : trans('back.after-morning');

            $_now = $_now > 12 ? ($_now - 12) : $_now;

            if ($diff < 2) {
                $fail('back.invalid-start-time-rule')->translate(['var' => ($_now).':00 '.$morning]);
            }
        }
    }
}
