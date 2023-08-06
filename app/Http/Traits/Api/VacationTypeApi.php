<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\VacationTypeResource;
use App\Models\VacationType;
use Illuminate\Http\JsonResponse;

trait VacationTypeApi
{
    public static function apiGetAllVacationTypes(): JsonResponse
    {
        $types = VacationType::withTranslation()->active()->get();

        return ApiResponse::response(VacationTypeResource::collection($types));
    }
}
