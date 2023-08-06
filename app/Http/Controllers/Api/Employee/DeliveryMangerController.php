<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\SetOrderDeliveryProviderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryMangerController extends PARENT_API
{
    public function getDeliveryMangerOrders(Request $request): JsonResponse
    {
        return Order::apiGetDeliveryMangerOrders($request);
    }

    public function getDeliveryProvidersList(Request $request): JsonResponse
    {
        return Order::apiGetDeliveryProvidersList($request);
    }

    public function getOngoingOrdersDeliveriesForDeliveryManger(Request $request): JsonResponse
    {
        return Order::apiGetOngoingOrdersDeliveriesForDeliveryManger($request);
    }

    public function getOngoingOrdersReceiptsForDeliveryManger(Request $request): JsonResponse
    {
        return Order::apiGetOngoingOrdersReceiptsForDeliveryManger($request);
    }

    public function getFinishedOrdersDeliveriesForDeliveryManger(Request $request): JsonResponse
    {
        return Order::apiGetFinishedOrdersDeliveriesForDeliveryManger($request);
    }

    public function getFinishedOrdersReceiptsForDeliveryManger(Request $request): JsonResponse
    {
        return Order::apiGetFinishedOrdersReceiptsForDeliveryManger($request);
    }

    public function setOrderDeliveryProvider(SetOrderDeliveryProviderRequest $request): JsonResponse
    {
        return Order::apiSetOrderDeliveryProvider($request);
    }
}
