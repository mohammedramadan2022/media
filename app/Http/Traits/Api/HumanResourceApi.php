<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\HumanResourceResource;
use App\Models\HumanResource;
use Illuminate\Http\JsonResponse;

trait HumanResourceApi
{
    public static function apiGetHumanResourcePage(): JsonResponse
    {
        $files = HumanResource::whereStatus(1)->withTranslation()->get();

        return ApiResponse::response(HumanResourceResource::collection($files));
    }
}
