<?php

namespace App\Http\Traits;

use App\Http\Scopes\WalletScopes;
use App\Http\Traits\Api\WalletApi;

trait WalletTrait
{
    use BasicTrait, WalletScopes, WalletApi;
}
