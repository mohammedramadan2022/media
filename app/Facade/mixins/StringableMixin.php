<?php

namespace App\Facade\mixins;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class StringableMixin
{
    public function ucwords(): Closure
    {
        return fn () => /** @var Stringable $this */ new Stringable(Str::ucwords($this->value));
    }
}
