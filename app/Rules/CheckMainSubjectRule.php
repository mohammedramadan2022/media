<?php

namespace App\Rules;

use App\Models\Subject;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckMainSubjectRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $subject = Subject::find($value);

        if ($subject->parent_id != 0) {
            $fail('api.subject-is-not-main')->translate();
        }
    }
}
