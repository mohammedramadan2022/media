<?php

namespace App\Http\Traits;

use App\Http\Scopes\HumanResourceScopes;
use App\Http\Traits\Api\HumanResourceApi;

trait HumanResourceTrait
{
    use BasicTrait, HumanResourceScopes, HumanResourceApi;
}
