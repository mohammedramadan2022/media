<?php

namespace App\Http\Traits\Other;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\Employee\EmployeeOrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

trait OrdersOfficer
{
    public static function apiGetOrdersOfficerNewOrders($request): JsonResponse
    {
        $orders = Order::pending()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetOngoingForOrdersOfficer($request): JsonResponse
    {
        $orders = Order::accepted()->orProcessing()->orProcessed()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetFinishedForOrdersOfficer($request): JsonResponse
    {
        $orders = Order::returns()->orCanceled()->orRejected()->orRejectedFromWarehouse()->orDeliveryToWarehouse()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }
}
