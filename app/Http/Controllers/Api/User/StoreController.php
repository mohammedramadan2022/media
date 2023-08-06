<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\GetStoreByIdRequest;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;

class StoreController extends PARENT_API
{
    public function getAllStores(): JsonResponse
    {
        return Provider::apiGetAllStores();
    }

    public function getStoreById(GetStoreByIdRequest $request): JsonResponse
    {
        return Provider::apiGetStoreById($request);
    }

    public function getOffersByStoreId(GetStoreByIdRequest $request): JsonResponse
    {
        return Provider::apiGetOffersByStoreId($request);
    }

    public function getSingleStoreSectionWithCategories(GetStoreByIdRequest $request): JsonResponse
    {
        return Provider::apiGetSingleStoreSectionWithCategories($request);
    }

    public function getStoreRates(GetStoreByIdRequest $request): JsonResponse
    {
        return Provider::apiGetStoreRates($request);
    }
}
