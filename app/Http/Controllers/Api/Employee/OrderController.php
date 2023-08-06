<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\SetEmployeeOrderActionRequest;
use App\Http\Requests\Api\User\orders\GetOrderByIdRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends PARENT_API
{
    public function setEmployeeOrderAction(SetEmployeeOrderActionRequest $request): JsonResponse
    {
        return Order::apiSetEmployeeOrderAction($request);
    }

    public function getOrderDetailsById(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiGetOrderDetailsById($request);
    }
}
