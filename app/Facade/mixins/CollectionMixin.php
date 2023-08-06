<?php

namespace App\Facade\mixins;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CollectionMixin
{
    public function paginate(): Closure
    {
        return function ($perPage, $total = null, $page = null, $pageName = 'page') {
            /** @var Collection $this */
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        };
    }

    public function sortByDescByIds(): Closure
    {
        return fn ($ids) => /** @var Collection $this */ $this->sortByDesc(function ($subject) use ($ids) {
            return in_array($subject->id, $ids);
        });
    }
}
