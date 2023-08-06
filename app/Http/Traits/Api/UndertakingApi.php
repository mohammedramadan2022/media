<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Models\{Notification, Undertaking};
use Illuminate\Http\JsonResponse;

trait UndertakingApi
{
    public static function apiSetOrderUndertaking($request): JsonResponse
    {
        $undertaking = Undertaking::firstOrcreate([
            'admin_id' => $request->user()->id,
            'order_id' => $request->order_id,
            'content' => $request->content,
        ]);

        Notification::sendUserOrderUndertaking($request->order_id, $undertaking->id);

        return ApiResponse::success();
    }
}
