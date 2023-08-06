<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\SetEmployeeVacationDemandRequest;
use App\Models\Vacation;
use App\Models\VacationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VacationController extends PARENT_API
{
    public function setEmployeeVacationDemand(SetEmployeeVacationDemandRequest $request): JsonResponse
    {
        return Vacation::apiSetEmployeeVacationDemand($request);
    }

    public function getEmployeeVacationDemands(Request $request): JsonResponse
    {
        return Vacation::apiGetEmployeeVacationDemands($request);
    }

    public function getVacationTypes(): JsonResponse
    {
        return VacationType::apiGetAllVacationTypes();
    }
}
