<?php

namespace App\Http\Traits;

use App\Http\Scopes\FavoriteScopes;
use App\Http\Traits\Api\FavoriteApi;

trait FavoriteTrait
{
    use BasicTrait, FavoriteScopes, FavoriteApi;
}
