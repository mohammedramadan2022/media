<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\PreviewResource;
use App\Models\Preview;
use Illuminate\Http\JsonResponse;

trait PreviewApi
{
    public static function apiGetAllPreviews(): JsonResponse
    {
        $previews = Preview::active()->get();

        return ApiResponse::response(PreviewResource::collection($previews));
    }
}
