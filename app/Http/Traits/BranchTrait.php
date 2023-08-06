<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\BranchScopes;
use App\Models\Branch;

trait BranchTrait
{
    use BasicTrait, BranchScopes;

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(Branch::class, 'name');
    }
}
