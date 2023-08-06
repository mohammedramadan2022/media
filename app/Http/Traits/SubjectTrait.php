<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\SubjectScopes;
use App\Http\Traits\Api\SubjectApi;
use App\Models\Subject;

trait SubjectTrait
{
    use BasicTrait, SubjectScopes, SubjectApi;

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(Subject::class, 'name');
    }
}
