<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AppAccessCodeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (User::where('own_access_code', $value)->count() == 0) {
            $fail('api.app_access_code')->translate();
        }
    }
}
