<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class AudioCheckRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Str::contains($value->getMimeType(), 'audio')) {
            $fail('Sorry, The file must be an audio type');
        }
    }
}
