<?php

namespace App\Rules;

use App\Facade\Support\Core\Regex;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YoutubeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Regex::youtube($value)) {
            $fail('حقل رابط الفيديو يجب ان يكون رابط يوتيوب صحيح');
        }
    }
}
