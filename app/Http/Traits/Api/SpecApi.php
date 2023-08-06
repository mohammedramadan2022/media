<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\{User\ProductResource, User\SpecResource};
use App\Models\{Category, OptionProduct, Product};
use Illuminate\Http\JsonResponse;

trait SpecApi
{
    public static function apiGetSpecsByCategoryId($request): JsonResponse
    {
        $category = Category::whereId($request->category_id)->with(['specs.translation', 'specs.options'])->first();

        return ApiResponse::response(SpecResource::collection($category->specs->sortBy('dropdown')));
    }

    public static function apiGetDefaultSpecForSection($request): JsonResponse
    {
        $category = Category::whereSectionId($request->section_id)->has('specs')->with(['specs.translation', 'specs.options'])->first();

        return ApiResponse::response(SpecResource::collection($category?->specs?->sortBy('dropdown') ?? collect([])));
    }

    public static function apiGetDefaultSpecForCategory($request): JsonResponse
    {
        $category = Category::whereId($request->category_id)->has('specs')->with(['specs.translation', 'specs.options'])->first();

        $specs = isset($category->specs) ? $category->specs->sortBy('dropdown') : [];

        return ApiResponse::response(SpecResource::collection($specs));
    }

    public static function apiGetAbsoluteSpec(): JsonResponse
    {
        $category = Category::has('specs')->with(['specs.translation', 'specs.options'])->first();

        return ApiResponse::response([
            'category_id' => $category->id ?? 0,
            'specs' => SpecResource::collection($category?->specs?->sortBy('dropdown') ?? collect([])),
        ]);
    }

    public static function apiGetProductsByOptionId($request): JsonResponse
    {
        $product_ids = OptionProduct::getProductsBySpecsAndOptions($request->options);

        $products = Product::query()
            ->whereIn('id', $product_ids)
            ->where('category_id', $request->category_id)
            ->with(['translation', 'images', 'section.translation', 'category.translation'])
            ->active()
            ->paginate(9);

        return ApiResponse::pagination($products, ProductResource::class);
    }
}
