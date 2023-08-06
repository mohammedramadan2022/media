<?php

namespace App\Rules;

use App\Facade\Support\Core\Uploaded;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitVideoResolutionRule implements ValidationRule
{
    public function __construct(public mixed $limit) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Uploaded::getVideoInfo($value->getPathName())['height'] == $this->limit)
        {
            $fail('back.limit-video-resolution-rule')->translate(['limit' => $this->limit]);
        }
    }
}
