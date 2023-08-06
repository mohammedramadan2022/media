<?php

namespace App\Http\Traits\Other;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\Employee\EmployeeOrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

trait WarehouseManger
{
    public static function apiGetWarehouseMangerNewOrders($request): JsonResponse
    {
        $orders = Order::deliveryToWarehouse()->orRejectedFromWarehouse()->paginate(10);

        return ApiResponse::pagination($orders,EmployeeOrderResource::class);
    }
}
