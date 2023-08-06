<?php

namespace App\Http\Traits;

use App\Http\Scopes\UserScopes;
use App\Http\Traits\Api\UserApi;

trait UserTrait
{
    use BasicTrait, UserApi, UserScopes;
}
