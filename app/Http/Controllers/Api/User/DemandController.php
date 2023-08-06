<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\CheckConfirmPhoneCodeRequest;
use App\Http\Requests\Api\User\ResendConfirmPhoneCodeRequest;
use App\Http\Requests\Api\User\SetUserJoinRequest;
use App\Models\Demand;
use Illuminate\Http\JsonResponse;

class DemandController extends PARENT_API
{
    public function setUserJoinRequest(SetUserJoinRequest $request): JsonResponse
    {
        return Demand::apiSetUserJoinRequest($request);
    }

    public function resendConfirmPhoneCode(ResendConfirmPhoneCodeRequest $request): JsonResponse
    {
        return Demand::apiResendConfirmPhoneCode($request);
    }

    public function checkConfirmPhoneCode(CheckConfirmPhoneCodeRequest $request): JsonResponse
    {
        return Demand::apiCheckConfirmCode($request);
    }

    public function checkDemandExists(ResendConfirmPhoneCodeRequest $request): JsonResponse
    {
        return Demand::apiCheckDemandExists($request);
    }
}
