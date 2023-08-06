<?php

namespace App\Rules;

use App\Facade\Support\Core\Uploaded;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitVideoDurationRule implements ValidationRule
{
    public function __construct(public mixed $limit = '02:00') {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $info = Uploaded::getVideoInfo($value->getPathName());

        if (strtotime($info['duration']) < strtotime($this->limit)) {
            $fail('back.limit-video-duration-rule')->translate(['limit' => $this->limit]);
        }
    }
}
