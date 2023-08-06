<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MainCategoryRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $check = ($value != 0) ? Category::find($value) : true;

        if (! $check) {
            $fail('api.category-is-not-found')->translate();
        }
    }
}
