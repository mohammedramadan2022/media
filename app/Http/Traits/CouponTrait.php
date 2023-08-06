<?php

namespace App\Http\Traits;

use App\Http\Scopes\CouponScopes;
use App\Http\Traits\Api\CouponApi;

trait CouponTrait
{
    use BasicTrait, CouponScopes, CouponApi;
}
