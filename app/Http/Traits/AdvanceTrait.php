<?php

namespace App\Http\Traits;

use App\Http\Scopes\AdvanceScopes;
use App\Http\Traits\Api\AdvanceApi;

trait AdvanceTrait
{
    use BasicTrait, AdvanceScopes, AdvanceApi;
}
