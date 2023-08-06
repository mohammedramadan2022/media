<?php

namespace App\Http\Traits;

use App\Http\Scopes\VacationTypeScopes;
use App\Http\Traits\Api\VacationTypeApi;

trait VacationTypeTrait
{
    use BasicTrait, VacationTypeScopes, VacationTypeApi;
}
