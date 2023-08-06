<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Models\Order;
use App\Models\Provider;
use App\Repository\Contracts\IOrderRepository;
use Illuminate\Http\Request;

class OrderController extends RepoController
{
    public function __construct(IOrderRepository $repository)
    {
        parent::__construct($repository);
    }

    public function types($type)
    {
        return self::repo()->types($type);
    }

    public function accept(Order $order)
    {
        return self::repo()->accept($order);
    }

    public function finalAccept(Order $order)
    {
        return self::repo()->finalAccept($order);
    }

    public function orderCashPaid(Order $order)
    {
        return self::repo()->orderCashPaid($order);
    }

    public function delayCashPaidAction(Order $order, $type)
    {
        return self::repo()->delayCashPaidAction($order, $type);
    }

    public function reject(Order $order)
    {
        return self::repo()->reject($order);
    }

    public function rejectProviderOrder(Order $order, Provider $provider)
    {
        return self::repo()->rejectProviderOrder($order, $provider);
    }

    public function changeOrderStatus(Request $request)
    {
        return self::repo()->changeOrderStatus($request);
    }

    public function isOrderAccepted(Request $request, Order $order)
    {
        return self::repo()->isOrderAccepted($request, $order);
    }

    public function showOrderPaymentProcess($order_id)
    {
        return self::repo()->showOrderPaymentProcess($order_id);
    }

    public function showOrderProviders($order_id)
    {
        return self::repo()->showOrderProviders($order_id);
    }

    public function setOrderToBePaid(Request $request)
    {
        return self::repo()->setOrderToBePaid($request);
    }

    public function setOrderProvider(Request $request)
    {
        return self::repo()->setOrderProvider($request);
    }
}
