<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\SetDeliveryProviderActionRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryProviderController extends PARENT_API
{
    public function getDeliveryProviderNewOrders(Request $request): JsonResponse
    {
        return Order::apiGetDeliveryProviderNewOrders($request);
    }

    public function getOngoingDeliveriesForDeliveryProvider(Request $request): JsonResponse
    {
        return Order::apiGetOngoingDeliveriesForDeliveryProvider($request);
    }

    public function getOngoingReceiptsForDeliveryProvider(Request $request): JsonResponse
    {
        return Order::apiGetOngoingReceiptsForDeliveryProvider($request);
    }

    public function getFinishedOrdersDeliveriesForDeliveryProvider(Request $request): JsonResponse
    {
        return Order::apiGetFinishedOrdersDeliveriesForDeliveryProvider($request);
    }

    public function getFinishedOrdersReceiptsForDeliveryProvider(Request $request): JsonResponse
    {
        return Order::apiGetFinishedOrdersReceiptsForDeliveryProvider($request);
    }

    public function setDeliveryProviderAction(SetDeliveryProviderActionRequest $request): JsonResponse
    {
        return Order::apiSetDeliveryProviderAction($request);
    }
}
