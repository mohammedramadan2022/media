<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\SetEmployeeAdvanceDemandRequest;
use App\Models\Advance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvanceController extends PARENT_API
{
    public function setEmployeeAdvanceDemand(SetEmployeeAdvanceDemandRequest $request): JsonResponse
    {
        return Advance::apiSetEmployeeAdvanceDemand($request);
    }

    public function getEmployeeAdvanceDemands(Request $request): JsonResponse
    {
        return Advance::apiGetEmployeeAdvanceDemands($request);
    }
}
