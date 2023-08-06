<?php

namespace App\Facade\mixins;

use Closure;

class StrMixin
{
    public function ucwords(): Closure
    {
        return fn ($text) => ucwords($text);
    }
}
