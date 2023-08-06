<?php

namespace App\Http\Traits;

use App\Http\Scopes\VacationScopes;
use App\Http\Traits\Api\VacationApi;

trait VacationTrait
{
    use BasicTrait, VacationScopes, VacationApi;
}
