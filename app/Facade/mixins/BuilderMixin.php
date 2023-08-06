<?php

namespace App\Facade\mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class BuilderMixin
{
    public function last(): Closure
    {
        return fn () => /** @var Builder $this */ $this->latest()->first();
    }

    public function whereLike(): Closure
    {
        return fn ($col, $value) => /** @var Builder $this */ $this->where($col,'LIKE',"%$value%");
    }

    public function orWhereLike(): Closure
    {
        return fn ($col, $value) => /** @var Builder $this */ $this->orWhere($col,'LIKE',"%$value%");
    }
}
