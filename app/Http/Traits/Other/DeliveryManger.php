<?php

namespace App\Http\Traits\Other;

use App\Enums\{OrderStatus, RoleEnum};
use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Http\Resources\{Employee\EmployeeDeliveryProviderResource, Employee\EmployeeOrderResource};
use App\Models\{Admin, AdminStatus, Notification, Order};
use Illuminate\Http\JsonResponse;

trait DeliveryManger
{
    public static function apiGetDeliveryMangerOrders($request): JsonResponse
    {
        $orders = Order::processed()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetOngoingOrdersDeliveriesForDeliveryManger($request): JsonResponse
    {
        $orders = Order::readyForDelivery()->orInDelivery()->orRejectedByProvider()->orNotReceived()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetOngoingOrdersReceiptsForDeliveryManger($request): JsonResponse
    {
        $orders = Order::deliveryToWarehouse()->orRetrieving()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetFinishedOrdersDeliveriesForDeliveryManger($request): JsonResponse
    {
        $orders = Order::delivered()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetFinishedOrdersReceiptsForDeliveryManger($request): JsonResponse
    {
        $orders = [];

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetDeliveryProvidersList($request): JsonResponse
    {
        $providers = Admin::whereStatus(1)->where('role_id', RoleEnum::DELIVERY_PROVIDER)->paginate(10);

        return ApiResponse::pagination($providers, EmployeeDeliveryProviderResource::class);
    }

    public static function apiSetOrderDeliveryProvider($request): JsonResponse
    {
        $order = Order::find($request->order_id);

        if ($order->provider_id) return Warning::sorryThisOrderAlreadyHasProvider();

        $check = AdminStatus::whereAdminId($request->provider_id)->first();

        if (! $check->is_available) return Warning::sorryThisProviderIsNotAvailable();

        $order->update(['provider_id' => $request->provider_id, 'status' => OrderStatus::READY_FOR_DELIVERY]);

        Notification::sendDeliveryProviderNewOrder($order, $request->provider_id);

        return ApiResponse::success();
    }
}
