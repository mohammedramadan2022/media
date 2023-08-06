<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseMangerController extends PARENT_API
{
    public function getWarehouseMangerNewOrders(Request $request): JsonResponse
    {
        return Order::apiGetWarehouseMangerNewOrders($request);
    }
}
