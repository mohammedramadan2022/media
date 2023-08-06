<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\SetOrderUndertakingRequest;
use App\Models\Order;
use App\Models\Undertaking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdersOfficerController extends PARENT_API
{
    public function getOrdersOfficerNewOrders(Request $request): JsonResponse
    {
        return Order::apiGetOrdersOfficerNewOrders($request);
    }

    public function getOngoingForOrdersOfficer(Request $request): JsonResponse
    {
        return Order::apiGetOngoingForOrdersOfficer($request);
    }

    public function getFinishedForOrdersOfficer(Request $request): JsonResponse
    {
        return Order::apiGetFinishedForOrdersOfficer($request);
    }

    public function setOrderUndertaking(SetOrderUndertakingRequest $request): JsonResponse
    {
        return Undertaking::apiSetOrderUndertaking($request);
    }
}
