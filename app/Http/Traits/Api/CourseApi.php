<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

trait CourseApi
{
    public static function apiGetCoursesPage(): JsonResponse
    {
        $courses = Course::active()->get();

        return ApiResponse::response(CourseResource::collection($courses));
    }
}
