<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Models\Course;
use App\Models\HumanResource;
use Illuminate\Http\JsonResponse;

class PageController extends PARENT_API
{
    public function getHumanResourcePage(): JsonResponse
    {
        return HumanResource::apiGetHumanResourcePage();
    }

    public function getCoursesPage(): JsonResponse
    {
        return Course::apiGetCoursesPage();
    }
}
