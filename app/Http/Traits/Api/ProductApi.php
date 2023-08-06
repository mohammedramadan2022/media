<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Facade\Support\Tools\Rates;
use App\Http\Resources\User\{CitySectionWithCategoriesResource, ProductRatesResource, ProductResource};
use App\Http\Resources\User\{SingleProductResource, SectionWithCategoriesResource, StoreSectionWithCategoriesResource};
use App\Models\{Product, Section};
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait ProductApi
{
    public static function apiGetAllProducts(): JsonResponse
    {
        $products = Product::rentalProducts()->withRelations()->inRandomOrder()->paginate(9);

        return ApiResponse::pagination($products,ProductResource::class);
    }

    public static function apiGetProductById($request): JsonResponse
    {
        $data['product'] = Product::whereId($request->product_id)->withTranslation()->first();

        $data['similar'] = Product::similar($data['product'])->where('id','!=', $request->product_id)->withRelations()->limit(10)->get();

        return ApiResponse::response(SingleProductResource::make((object)$data));
    }

    public static function apiFilterProducts($request): JsonResponse
    {
        $query = Product::query()->withRelations();

        $query->when($request->filled('startDate') && $request->filled('endDate'), function (Builder $q) {
            $q->whereNotIn('products.id', Product::getRentedProducts());
        });

        $query->where('products.is_accepted', 1)->where('products.status', 1);

        $query->when($request->type == 'stores', fn($q) => $q->storeProducts());

        $query->when($request->type == 'general', fn($q) => $q->whereNull('products.type'));

        if ($request->filled('has_offer')) $query->where('products.has_offer', $request->has_offer);

        $query->when($request, fn($q, $req) => ($req->filled('store_id') ? $q->where('products.type_id', $req->store_id) : $q));

        $query->when($request, fn($q, $req) => ($req->filled('section_id') ? $q->where('products.section_id', $req->section_id) : $q));

        $query->when($request, fn($q, $req) => ($req->filled('category_id') ? $q->where('products.category_id', $req->category_id) : $q));

        $query->when($request, fn($q, $req) => ($req->filled('city_id')) ? $q->where('products.city_id', $req->city_id) : $q);

        $query->when($request->sort_by, function ($q, $sortBy) {
            if ($sortBy == 'price_low_high') $q->orderBy('products.price', 'ASC');
            if ($sortBy == 'price_high_low') $q->orderBy('products.price', 'DESC');
            if ($sortBy == 'rate') $q->orderBy('products.rate', 'DESC');
            if ($sortBy == 'recently') $q->orderBy('products.created_at', 'DESC');
        });

        $query->when($request, fn($q, $req) => ($req->has('term') && !is_null($req->term)) ? $q->search($req->term) : $q);

        return ApiResponse::pagination($query->paginate(9),ProductResource::class);
    }

    public static function apiSearch($request): JsonResponse
    {
        $query = Product::query();

        $query->where('is_accepted', 1)->where('status', 1);

        if ($request->has('section_id')) $query->where('section_id', $request->section_id);

        if ($request->has('term')) $query->search($request->term);

        return ApiResponse::pagination($query->paginate(9), ProductResource::class);
    }

    public static function apiSetUserProductRate($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $product = Product::find($request->product_id);

            if ($product->is_rated) return Warning::sorryThisProductAlreadyRated();

            $product->rates()->create([
                'name'    => $request->name,
                'user_id' => $request->user()->id,
                'comment' => $request->comment ?? null,
                'rate'    => $request->rate,
            ]);

            Rates::setCalculatedRate($product, $request->rate);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiGetProductsByCityId($request): JsonResponse
    {
        $products = Product::rentalProducts()->whereCityId($request->city_id)->withRelations()->inRandomOrder()->paginate(9);

        return ApiResponse::pagination($products, ProductResource::class);
    }

    public static function apiGetProductsBySectionId($request): JsonResponse
    {
        $products = Product::whenStoreExists($request)->whereSectionId($request->section_id)->withRelations()->inRandomOrder()->paginate(9);

        return ApiResponse::pagination($products, ProductResource::class);
    }

    public static function apiGetProductsByCategoryId($request): JsonResponse
    {
        $products = Product::whenStoreExists($request)->whereCategoryId($request->category_id)->active()->withRelations()->inRandomOrder()->paginate(9);

        return ApiResponse::pagination($products,ProductResource::class);
    }

    public static function apiGetStoresProductsByCategoryId($request): JsonResponse
    {
        $products = Product::storeProducts()->active()->withRelations()->whereCategoryId($request->category_id)->inRandomOrder()->paginate(9);

        return ApiResponse::pagination($products, ProductResource::class);
    }

    public static function apiGetAllOffers(): JsonResponse
    {
        $products = Product::rentalProducts()->whereHasOffer(1)->withRelations()->inRandomOrder()->paginate(9);

        return ApiResponse::pagination($products,ProductResource::class);
    }

    public static function apiGetCitySectionWithCategories($request): JsonResponse
    {
        return ApiResponse::response([
            'all'          => Product::rentalProducts()->onlyActiveSections()->count(),
            'offers_count' => Product::active()->whereHasOffer(1)->whereCityId($request->city_id)->whereNull('type')->count(),
            'sections'     => CitySectionWithCategoriesResource::collection(Section::active()->with(['translation', 'categories.translation'])->get()),
        ]);
    }

    public static function apiGetStoreSectionWithCategories(): JsonResponse
    {
        return ApiResponse::response([
            'all'          => Product::storeProducts()->onlyActiveSections()->count(),
            'offers_count' => Product::active()->whereHasOffer(1)->whereNotNull('type')->count(),
            'sections'     => StoreSectionWithCategoriesResource::collection(Section::active()->with(['translation', 'categories.translation'])->get()),
        ]);
    }

    public static function apiGetSectionWithCategories(): JsonResponse
    {
        return ApiResponse::response([
            'all'          => Product::rentalProducts()->onlyActiveSections()->count(),
            'offers_count' => Product::active()->whereHasOffer(1)->whereNull('type')->count(),
            'sections'     => SectionWithCategoriesResource::collection(Section::active()->with(['translation', 'categories.translation'])->get()),
        ]);
    }

    public static function apiGetProductRates($request): JsonResponse
    {
        return ApiResponse::response(ProductRatesResource::make(Product::find($request->product_id)));
    }

    public static function apiGetPopularProducts(): JsonResponse
    {
        $popular = Product::rentalProducts()->withRelations()->popular()->active()->inRandomOrder()->get();

        $products = $popular->merge(Product::rentalProducts()->withRelations()->inRandomOrder()->get());

        return ApiResponse::pagination($products->paginate(9),ProductResource::class);
    }
}
