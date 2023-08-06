<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\ChargeWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends PARENT_API
{
    public function getUserWallet(Request $request): JsonResponse
    {
        return Wallet::apiGetUserWallet($request);
    }

    public function chargeWallet(ChargeWalletRequest $request): JsonResponse
    {
        return Wallet::apiChargeWallet($request);
    }
}
