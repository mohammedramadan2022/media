<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\SetUserProductFavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends PARENT_API
{
    public function setOrRemoveUserProductFavorite(SetUserProductFavoriteRequest $request): JsonResponse
    {
        return Favorite::apiSetUserProductFavorite($request);
    }

    public function getUserFavorites(Request $request): JsonResponse
    {
        return Favorite::apiGetUserFavorites($request);
    }
}
