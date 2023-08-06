<?php

namespace App\Http\Traits;

use App\Http\Scopes\UndertakingScopes;
use App\Http\Traits\Api\UndertakingApi;

trait UndertakingTrait
{
    use BasicTrait, UndertakingScopes, UndertakingApi;
}
