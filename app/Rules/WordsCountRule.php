<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WordsCountRule implements ValidationRule
{
    public function __construct(public mixed $count) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count(explode(' ', $value)) < 2) {
            $fail('back.words-count-validation-error')->translate(['count' => $this->count]);
        }
    }
}
