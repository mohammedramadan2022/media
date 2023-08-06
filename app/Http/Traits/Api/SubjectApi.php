<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;

trait SubjectApi
{
    public static function apiGetAllSubjects($request): JsonResponse
    {
        $subjects = Subject::active()->withTranslation()->get();

        return ApiResponse::response(SubjectResource::collection($subjects));
    }
}
