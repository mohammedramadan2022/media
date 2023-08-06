<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\RemoveUserNotificationRequest;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends PARENT_API
{
    public function getUserNotifications(Request $request): JsonResponse
    {
        return Notification::apiGetAuthNotifications($request);
    }

    public function removeUserNotification(RemoveUserNotificationRequest $request): JsonResponse
    {
        return Notification::apiRemoveNotification($request);
    }

    public function deleteUserNotifications(Request $request): JsonResponse
    {
        return Notification::apiRemoveAllNotification($request);
    }

    public function getUserNewNotificationsCount(Request $request): JsonResponse
    {
        return Notification::apiGetAuthNewNotificationsCount($request);
    }
}
