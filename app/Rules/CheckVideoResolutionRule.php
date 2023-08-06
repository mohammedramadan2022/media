<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckVideoResolutionRule implements ValidationRule
{
    public function __construct(public $resolution) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->resolution <= getMediaInInfo($value->getRealPath())['video']['resolution_y'])
        {
            $fail('api.video-must-be-less-than-var')->translate(['var' => $this->resolution]);
        }
    }
}
