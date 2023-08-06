<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;

trait CityApi
{
    public static function apiGetAllCities(): JsonResponse
    {
        $cities = City::active()->withTranslation()->get();

        return ApiResponse::response(CityResource::collection($cities));
    }

    public static function apiGetCitiesHasProducts(): JsonResponse
    {
        $cities = City::active()->withTranslation()->has('cityProducts')->get();

        return ApiResponse::response(CityResource::collection($cities));
    }
}
