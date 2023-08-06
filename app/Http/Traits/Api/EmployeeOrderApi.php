<?php

namespace App\Http\Traits\Api;

use App\Enums\OrderStatus;
use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Http\Resources\Employee\EmployeeOrderDetailsResource;
use App\Http\Traits\Other\{DeliveryManger, DeliveryProvider, OrdersOfficer, WarehouseManger};
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

trait EmployeeOrderApi
{
    use OrdersOfficer, DeliveryManger, DeliveryProvider, WarehouseManger;

    public static function apiSetEmployeeOrderAction($request): JsonResponse
    {
        $order = Order::find($request->order_id);

        if (! $order) return Warning::sorryThisOrderNotExists();

        if ($order->status == $request->action) return ApiResponse::success('تم تغير الحالة بالفعل');

        if (! $order->is_payed && $request->action == OrderStatus::PROCESSING && $request->action == OrderStatus::PROCESSED) {
            return Warning::sorryThisOrderNotPaidYet();
        }

        if ($request->action == OrderStatus::CANCELED && $request->filled('reason')) {
            $order->reason()->updateOrCreate(['admin_id' => $request->user()->id, 'reason' => $request->reason]);
        }

        Order::updateOrderBy($request->action, $order);

        $request->user()->logger()->updateOrCreate(['order_id' => $order->id, 'status' => $request->action]);

        Notification::sendUserOrderNotification($order, $request->action);

        return ApiResponse::success();
    }

    public static function apiGetOrderDetailsById($request): JsonResponse
    {
        return ApiResponse::response(EmployeeOrderDetailsResource::make(Order::find($request->order_id)));
    }
}
