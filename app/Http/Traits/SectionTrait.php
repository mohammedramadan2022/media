<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\SectionScopes;
use App\Http\Traits\Api\SectionApi;
use App\Models\Section;

trait SectionTrait
{
    use BasicTrait, SectionApi, SectionScopes;

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(model: Section::class, withRelations: ['translations']);
    }
}
