<?php

namespace App\Rules;

use App\Models\Code;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckActivatedMobile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $check = ! Code::where('phone', request('phone'))->where('country_code', request('country_code'))->count();

        if ($check == 0) {
            $fail('api.phone-already-exists')->translate();
        }
    }
}
