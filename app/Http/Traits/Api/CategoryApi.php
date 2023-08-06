<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

trait CategoryApi
{
    public static function apiGetCategoriesBySectionId($request): JsonResponse
    {
        $categories = Category::whereSectionId($request->section_id)->whereStatus(1)->get();

        return ApiResponse::response(CategoryResource::collection($categories));
    }
}
