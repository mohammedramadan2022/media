<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueEmailRule implements ValidationRule
{
    public function __construct(public $table) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $check = DB::table($this->table)->whereEmail($value)->first();

        dd($check);
    }
}
