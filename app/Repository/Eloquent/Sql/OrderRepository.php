<?php

namespace App\Repository\Eloquent\Sql;

use App\Enums\{OrderStatus, PaymentEnum};
use App\Facade\Support\Core\Warning;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\{Admin, Provider, Notification, Order, OrderAddress, OrderProduct, OrderProvider};
use App\Repository\Contracts\IOrderRepository;
use Exception;
use Illuminate\Http\{JsonResponse, Request, RedirectResponse};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderRepository extends BaseRepository implements IOrderRepository
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function accept(Order $order): RedirectResponse
    {
        if ($order->hasOutOfStockProducts()) return Warning::sorrySomeOfProductsQtyIsOutOfStock();

        if ($order->store_products_count == 0) Notification::sendUserOrderReadyToPay($order);

        $order->beAccepted();

        return CrudMessage::success();
    }

    public function reject(Order $order): RedirectResponse
    {
        $order->beRejected();

        Notification::sendUserOrderRejected($order);

        return CrudMessage::success();
    }

    public function forceDelete($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {
            DB::table('order_product')->where('order_id', $id)->delete();

            DB::table('order_addresses')->where('order_id', $id)->delete();

            DB::table('order_provider')->where('order_id', $id)->delete();

            DB::table('orders')->where('id', $id)->delete();
        });

        return CrudMessage::remove($this->name);
    }

    public function show($id): View
    {
        return view('Back.' . $this->folder . '.show', [
            $this->name => $this->class::where('id', $id)->with(['products', 'products.translation', 'products.images'])->first(),
            'statuses'  => Order::statuses(),
        ]);
    }

    public function rejectProviderOrder(Order $order, Provider $provider): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $provider_order = OrderProvider::where('order_id', $order->id)->where('provider_id', $provider->id)->first();

            $order->beRejectedForProvider($provider_order);

            OrderProduct::whereOrderId($order->id)->whereType(Provider::class)->whereTypeId($provider->id)->delete();

            OrderAddress::whereOrderId($order->id)->where('addressable_type', Provider::class)->where('addressable_id', $provider->id)->delete();

            $provider_order->delete();

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public function types($type): View
    {
        $query = $this->model::query();

        if($type == 'new') $query->where('status', OrderStatus::PENDING)->where('is_rental_accept', 0);

        else $query->where('status', $type);

        return view('Back.Orders.index', ['orders' => $query->latest()->paginate(10)]);
    }

    public function finalAccept(Order $order): RedirectResponse
    {
        $order->beFinalAccepted();

        Notification::sendUserOrderReadyToPay($order);

        return CrudMessage::success();
    }

    public function orderCashPaid(Order $order): RedirectResponse
    {
        Order::payCash($order->id);

        Notification::sendCashPaid($order);

        return CrudMessage::success();
    }

    public function changeOrderStatus(Request $request): RedirectResponse
    {
        if (!$order = Order::find($request->order_id)) return redirect()->route('orders.index')->with('danger', 'عفوا هذا الطلب غير موجود');

        if (!array_key_exists($request->order_status, Order::statuses())) return Warning::sorryOrderStatusNotValid();

        if (!$order->is_payed && $request->order_status != OrderStatus::ACCEPTED) return Warning::sorryThisOrderNotPaidYet();

        if ($order->status === $request->order_status) return CrudMessage::success();

        if ($order->isNeedToSetProviderFirst($request->order_status)) return Warning::sorryThisOrderHasNoProvider();

        if ($order->canChangeStatusToPending($request->order_status)) return Warning::sorryCanNotChangeOrderStatusToPending();

        Order::updateOrderBy($request->order_status, $order);

        Notification::sendUserOrderNotification($order, $request->order_status);

        return CrudMessage::success();
    }

    public function isOrderAccepted(Request $request, Order $order): JsonResponse
    {
        $is_payed = $order->is_payed && $request->status != OrderStatus::ACCEPTED;

        return response()->json(['status' => true, 'is_payed' => $is_payed]);
    }

    public function showOrderPaymentProcess($order_id): string
    {
        return view('Back.Orders.showOrderPaymentProcessModal', compact('order_id'))->render();
    }

    public function setOrderToBePaid(Request $request): RedirectResponse
    {
        $order = Order::findOrFail($request->order_id);

        if ($order->canPayOrderByUserWallet($request->payment_method)) {
            return CrudMessage::danger('عفوا لا يوجد رصيد لإتمام عملية الدفع عن طريق المحفظة الإلكترونية');
        }

        match ($request->payment_method) {
            PaymentEnum::CASH   => Order::payCash($order->id),
            PaymentEnum::VISA   => Order::payVisa($order->id, 0),
            PaymentEnum::WALLET => Order::payWallet($order),
        };

        return CrudMessage::success();
    }

    public function showOrderProviders($order_id): string
    {
        return view('Back.Orders.showOrderProviderModal', ['order_id' => $order_id, 'providers' => Admin::getProviders()])->render();
    }

    public function setOrderProvider(Request $request): RedirectResponse
    {
        $order = Order::find($request->order_id);

        $provider = Admin::find($request->provider_id);

        if (!$provider || !$provider->is_active) return Warning::sorryThisProviderIsNotAvailable();

        $order->update(['status' => OrderStatus::READY_FOR_DELIVERY, 'provider_id' => $request->provider_id]);

        return CrudMessage::success();
    }

    public function delayCashPaidAction(Order $order, $type): RedirectResponse
    {
        $is_delay_paid = $type == 'accept' ? PaymentEnum::ACCEPTED_DELAY_CASH : PaymentEnum::REFUSED_DELAY_CASH;

        $order->update(['is_delay_paid' => $is_delay_paid, 'payment_status' => PaymentEnum::PAID, 'delay_penalty' => 0]);

        Notification::sendUserDelayPaidAction($order, $type);

        return CrudMessage::success();
    }
}
