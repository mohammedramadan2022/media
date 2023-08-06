<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UploadCount implements ValidationRule
{
    public function __construct(public mixed $count) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $files = request()->file($attribute);

        $_files = ! is_array($files) ? [$files] : $files;

        if (count($_files) <= $this->count) {
            $fail('back.upload-count-rule')->translate(['count' => $this->count]);
        }
    }
}
