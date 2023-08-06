<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\orders\{ChangeUserOrderAddressRequest, ChangeUserOrderDatesRequest, FilterUserOrdersRequest};
use App\Http\Requests\Api\User\orders\{GetOrderByIdRequest, GetOrderByNoRequest, GetUndertakingByIdRequest, SetUserOrderPayRequest};
use App\Http\Requests\Api\User\orders\{SetUserOrderUndertakingActionRequest, SetUserThrowbackDemandRequest};
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends PARENT_API
{
    public function getUserOrders(Request $request): JsonResponse
    {
        return Order::apiGetUserOrders($request);
    }

    public function getOrderById(GetOrderByNoRequest $request): JsonResponse
    {
        return Order::apiGetOrderById($request);
    }

    public function setUserOrderPay(SetUserOrderPayRequest $request): JsonResponse
    {
        return Payment::setUserOrderPay($request);
    }

    public function cancelUserOrder(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiCancelUserOrder($request);
    }

    public function changeUserOrderAddress(ChangeUserOrderAddressRequest $request): JsonResponse
    {
        return Order::apiChangeUserOrderAddress($request);
    }

    public function changeUserOrderDates(ChangeUserOrderDatesRequest $request): JsonResponse
    {
        return Order::apiChangeUserOrderDates($request);
    }

    public function filterUserOrders(FilterUserOrdersRequest $request): JsonResponse
    {
        return Order::apiFilterUserOrders($request);
    }

    public function setUserOrderPayCash(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiSetUserOrderPayCash($request);
    }

    public function setUserOrderPayByWallet(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiSetUserOrderPayByWallet($request);
    }

    public function setUserPayInsurance(SetUserOrderPayRequest $request): JsonResponse
    {
        return Order::apiSetUserPayInsurance($request);
    }

    public function getOrderStoresLocations(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiGetOrderStoresLocations($request);
    }

    public function getOrderUndertaking(GetUndertakingByIdRequest $request): JsonResponse
    {
        return Order::apiGetOrderUndertaking($request);
    }

    public function setUserOrderUndertakingAction(SetUserOrderUndertakingActionRequest $request): JsonResponse
    {
        return Order::apiSetUserOrderUndertakingAction($request);
    }

    public function setUserThrowbackDemand(SetUserThrowbackDemandRequest $request): JsonResponse
    {
        return Order::apiSetUserThrowbackDemand($request);
    }

    public function setUserDelayPay(SetUserOrderPayRequest $request): JsonResponse
    {
        return Payment::setUserDelayPay($request);
    }

    public function setUserDelayPayCash(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiSetUserDelayPayCash($request);
    }

    public function setUserDelayPayByWallet(GetOrderByIdRequest $request): JsonResponse
    {
        return Order::apiSetUserDelayPayByWallet($request);
    }
}
