<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Facade\Support\Core\Warning;
use App\Http\Resources\User\NotificationResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait NotificationApi
{
    public static function apiGetAuthNotifications($request): JsonResponse
    {
        $callback = fn ($item) => $item->update(['is_seen' => 1]);

        $request->user()->notifications->where('is_seen', 0)->map($callback);

        return ApiResponse::pagination($request->user()->notifications()->latest()->paginate(10), NotificationResource::class);
    }

    public static function apiRemoveNotification($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $notification = $request->user()->notifications()->find($request->notification_id);

            if (! $notification) return Warning::notificationIsNotFound();

            $notification->delete();

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiRemoveAllNotification($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            DB::table('notifications')->where('notificationable_type', User::class)->where('notificationable_id', $request->user()->id)->delete();

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiGetAuthNewNotificationsCount($request): JsonResponse
    {
        return ApiResponse::response([
            'count' => $request->user()->notifications->where('is_seen', 0)->count(),
        ]);
    }
}
