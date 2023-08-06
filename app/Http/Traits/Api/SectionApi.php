<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\SectionCategoryResource;
use App\Http\Resources\User\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;

trait SectionApi
{
    public static function apiGetSectionsWithCategories(): JsonResponse
    {
        $sections = Section::active()->get();

        return ApiResponse::response(SectionCategoryResource::collection($sections));
    }

    public static function apiGetAllSections(): JsonResponse
    {
        $sections = Section::active()->withTranslation()->get();

        return ApiResponse::response(SectionResource::collection($sections));
    }
}
