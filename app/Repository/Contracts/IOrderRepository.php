<?php

namespace App\Repository\Contracts;

use App\Models\Order;
use App\Models\Provider;
use Illuminate\Http\Request;

/**
 * @method all()
 * @method paginate()
 * @method find($id)
 * @method delete($id)
 * @method forceDelete($id)
 * @method index()
 * @method trashed()
 * @method restore($id)
 * @method search($request)
 * @method export()
 */
interface IOrderRepository
{
    public function types($type);

    public function finalAccept(Order $order);

    public function accept(Order $order);

    public function reject(Order $order);

    public function orderCashPaid(Order $order);

    public function delayCashPaidAction(Order $order, $type);

    public function rejectProviderOrder(Order $order, Provider $provider);

    public function changeOrderStatus(Request $request);

    public function isOrderAccepted(Request $request, Order $order);

    public function showOrderPaymentProcess($order_id);

    public function showOrderProviders($order_id);

    public function setOrderToBePaid(Request $request);

    public function setOrderProvider(Request $request);
}
