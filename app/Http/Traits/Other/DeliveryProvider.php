<?php

namespace App\Http\Traits\Other;

use App\Enums\OrderStatus;
use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Http\Resources\Employee\EmployeeOrderResource;
use App\Models\{Notification, Order};
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait DeliveryProvider
{
    public static function apiGetDeliveryProviderNewOrders($request): JsonResponse
    {
        $orders = Order::whereProviderId($request->user()->id)->readyForDelivery()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetOngoingDeliveriesForDeliveryProvider($request): JsonResponse
    {
        $orders = Order::whereProviderId($request->user()->id)->inDelivery()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetOngoingReceiptsForDeliveryProvider($request): JsonResponse
    {
        $orders = Order::whereProviderId($request->user()->id)->retrieving()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetFinishedOrdersDeliveriesForDeliveryProvider($request): JsonResponse
    {
        $orders = Order::whereProviderId($request->user()->id)->delivered()->paginate(10);

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiGetFinishedOrdersReceiptsForDeliveryProvider($request): JsonResponse
    {
        $orders = [];

        return ApiResponse::pagination($orders, EmployeeOrderResource::class);
    }

    public static function apiSetDeliveryProviderAction($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $order = Order::find($request->order_id);

            if ($order->status == OrderStatus::CANCELED || $order->status == OrderStatus::REJECTED_BY_PROVIDER) {
                return Warning::sorryThisOrderHasBeenCanceled();
            }

            if (! $order->is_payed) {
                return Warning::sorryThisOrderNotPaidYet();
            }

            if ($request->action == 'reject' && $request->filled('reason')) {
                $order->update(['status' => OrderStatus::REJECTED_BY_PROVIDER, 'provider_id' => null]);

                $order->reason()->updateOrCreate(['admin_id' => $request->user()->id, 'reason' => $request->reason]);

                DB::commit();

                return ApiResponse::success();
            }

            $order->updateOrderStatus(OrderStatus::IN_DELIVERY);

            $request->user()->logger()->updateOrCreate(['order_id' => $order->id, 'status' => OrderStatus::IN_DELIVERY]);

            Notification::sendUserOrderNotification($order, OrderStatus::IN_DELIVERY);

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }
}
