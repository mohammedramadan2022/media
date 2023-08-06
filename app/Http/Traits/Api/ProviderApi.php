<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Facade\Support\Tools\Rates;
use App\Http\Resources\User\{ProviderRatesResource, ProductResource, ProviderResource, StoreSectionWithCategoriesResource};
use App\Models\{Product, Provider, Section};
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait ProviderApi
{
    public static function apiGetAllStores(): JsonResponse
    {
        $stores = Provider::active()->with(['city.translation', 'rates'])->paginate(12);

        return ApiResponse::pagination($stores,ProviderResource::class);
    }

    public static function apiGetStoreById($request): JsonResponse
    {
        $query = Product::query()->with(['translation', 'images', 'section.translation', 'category.translation']);

        $query->storeProducts($request->store_id);

        if ($request->filled('sort_by')) {
            if ($request->sort_by == 'price_low_high' || $request->sort_by == 'price_high_low') {
                $query->orderBy('price', $request->sort_by == 'price_high_low' ? 'DESC' : 'ASC');
            }

            if ($request->sort_by == 'recently') $query->latest();

            if ($request->sort_by == 'rate') $query->orderBy('rate', 'DESC');
        }

        $products = $query->get();

        return ApiResponse::response([
            'store'    => ProviderResource::make(Provider::find($request->store_id)),
            'products' => ProductResource::collection($products),
        ]);
    }

    public static function apiGetOffersByStoreId($request): JsonResponse
    {
        $offers = Product::storeProductsHasOffer($request->store_id)->get();

        return ApiResponse::pagination($offers, ProductResource::class, 9);
    }

    public static function apiGetSingleStoreSectionWithCategories($request): JsonResponse
    {
        return ApiResponse::response([
            'all'          => Product::storeProducts($request->store_id)->count(),
            'offers_count' => Product::whereHasOffer(1)->whenStoreIs($request->store_id)->count(),
            'sections'     => StoreSectionWithCategoriesResource::collection(Section::active()->with(['translation', 'categories.translation'])->get()),
        ]);
    }

    public static function apiSetUserStoreRate($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $store = Provider::find($request->store_id);

            if ($store->is_rated) return Warning::sorryThisStoreAlreadyRated();

            $store->rates()->create([
                'name'    => $request->name,
                'user_id' => $request->user()->id,
                'comment' => $request->comment ?? null,
                'rate'    => $request->rate,
            ]);

            Rates::setCalculatedRate($store, $request->rate);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiGetStoreRates($request): JsonResponse
    {
        return ApiResponse::response(ProviderRatesResource::make(Provider::find($request->store_id)));
    }
}
