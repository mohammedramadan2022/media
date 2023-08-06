<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\{FilterProductsRequest, GetCitySectionWithCategoriesRequest, GetProductByIdRequest, GetProductsByCategoryIdRequest};
use App\Http\Requests\Api\User\{GetProductsByCityIdRequest, GetProductsByOptionIdRequest, GetProductsBySectionIdRequest};
use App\Http\Requests\Api\User\{SetUserProductRateRequest, SetUserStoreRateRequest};
use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Section;
use App\Models\Spec;
use Illuminate\Http\JsonResponse;

class ProductController extends PARENT_API
{
    public function getAllProducts(): JsonResponse
    {
        return Product::apiGetAllProducts();
    }

    public function filterProducts(FilterProductsRequest $request): JsonResponse
    {
        return Product::apiFilterProducts($request);
    }

    public function search(FilterProductsRequest $request): JsonResponse
    {
        return Product::apiSearch($request);
    }

    public function getSectionWithCategories(): JsonResponse
    {
        return Product::apiGetSectionWithCategories();
    }

    public function getDefaultSpecForSection(GetProductsBySectionIdRequest $request): JsonResponse
    {
        return Spec::apiGetDefaultSpecForSection($request);
    }

    public function getDefaultSpecForCategory(GetProductsByCategoryIdRequest $request): JsonResponse
    {
        return Spec::apiGetDefaultSpecForCategory($request);
    }

    public function getAbsoluteSpec(): JsonResponse
    {
        return Spec::apiGetAbsoluteSpec();
    }

    public function getSpecsByCategoryId(GetProductsByCategoryIdRequest $request): JsonResponse
    {
        return Spec::apiGetSpecsByCategoryId($request);
    }

    public function getProductsByOptionId(GetProductsByOptionIdRequest $request): JsonResponse
    {
        return Spec::apiGetProductsByOptionId($request);
    }

    public function getStoreSectionWithCategories(): JsonResponse
    {
        return Product::apiGetStoreSectionWithCategories();
    }

    public function getCitySectionWithCategories(GetCitySectionWithCategoriesRequest $request): JsonResponse
    {
        return Product::apiGetCitySectionWithCategories($request);
    }

    public function getStoresProductsByCategoryId(GetProductsByCategoryIdRequest $request): JsonResponse
    {
        return Product::apiGetStoresProductsByCategoryId($request);
    }

    public function getAllOffers(): JsonResponse
    {
        return Product::apiGetAllOffers();
    }

    public function getProductById(GetProductByIdRequest $request): JsonResponse
    {
        return Product::apiGetProductById($request);
    }

    public function setUserProductRate(SetUserProductRateRequest $request): JsonResponse
    {
        return Product::apiSetUserProductRate($request);
    }

    public function setUserStoreRate(SetUserStoreRateRequest $request): JsonResponse
    {
        return Provider::apiSetUserStoreRate($request);
    }

    public function getProductsByCityId(GetProductsByCityIdRequest $request): JsonResponse
    {
        return Product::apiGetProductsByCityId($request);
    }

    public function getProductsBySectionId(GetProductsBySectionIdRequest $request): JsonResponse
    {
        return Product::apiGetProductsBySectionId($request);
    }

    public function getProductsByCategoryId(GetProductsByCategoryIdRequest $request): JsonResponse
    {
        return Product::apiGetProductsByCategoryId($request);
    }

    public function getSectionsWithCategories(): JsonResponse
    {
        return Section::apiGetSectionsWithCategories();
    }

    public function getCategoriesBySectionId(GetProductsBySectionIdRequest $request): JsonResponse
    {
        return Category::apiGetCategoriesBySectionId($request);
    }

    public function getProductRates(GetProductByIdRequest $request): JsonResponse
    {
        return Product::apiGetProductRates($request);
    }
}
