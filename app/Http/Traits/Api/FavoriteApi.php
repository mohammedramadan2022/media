<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\FavoriteResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait FavoriteApi
{
    public static function apiSetUserProductFavorite($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if ($request->type == 'remove') {
                DB::table('favorites')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $request->user()->id)
                    ->delete();

                DB::commit();

                return ApiResponse::success();
            }

            $request->user()->favorites()->firstOrCreate(['product_id' => $request->product_id]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiGetUserFavorites($request): JsonResponse
    {
        $with = ['product.category.translation','product.translation', 'product.images', 'product.section.translation', 'product.city.translation'];

        $favorites = $request->user()->favorites()->has('product')->with($with)->paginate(10);

        return ApiResponse::pagination($favorites,FavoriteResource::class);
    }
}
