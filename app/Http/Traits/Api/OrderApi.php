<?php

namespace App\Http\Traits\Api;

use App\Enums\{OrderStatus, PaymentEnum};
use App\Facade\Support\Core\{ApiResponse, Pay, Warning};
use App\Http\Resources\User\{OrderDetailsResource, OrderResource, UndertakingResource};
use App\Http\Resources\Employee\EmployeeOrderResource;
use App\Models\{Address, Cart, Notification, Order, OrderProduct, Payment, Product, Provider, Throwback, Undertaking, User};
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait OrderApi
{
    use EmployeeOrderApi;

    public static function apiGetUserOrders($request): JsonResponse
    {
        $orders = $request->user()->orders()->where('status', '!=', OrderStatus::CANCELED)->latest()->paginate(10);

        return ApiResponse::pagination($orders, OrderResource::class);
    }

    public static function apiGetOrderById($request): JsonResponse
    {
        $order = Order::whereOrderNo($request->order_no)->first();

        if ($order->status == OrderStatus::CANCELED) return Warning::sorryThisOrderHasBeenCanceled();

        return ApiResponse::response(OrderDetailsResource::make($order));
    }

    public static function apiChangeUserOrderAddress($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $order = Order::find($request->order_id);

            if ($request->delivery_type == 'address')
            {
                $address = Address::find($request->address_id);

                if ($order->user->city_id !== $address->city_id) return Warning::sorryYourOrderAddressNotMatchDefaultAddress();

                DB::table('order_addresses')->where('order_id', $order->id)->delete();

                DB::table('order_addresses')->insert([
                    'order_id'         => $order->id,
                    'addressable_id'   => $request->user()->id,
                    'addressable_type' => User::class,
                    'address'          => $address->full_address,
                    'phone'            => $address->phone,
                ]);

                $request->user()->update(['address_id' => $address->id]);

                $order->update(['delivery_type' => 'address']);
            }

            if ($order->store_products_count > 0 && $request->delivery_type == 'location')
            {
                $addresses = [];

                DB::table('order_addresses')->where('order_id', $order->id)->delete();

                $providers = OrderProduct::whereType(Provider::class)->whereOrderId($order->id)->get();

                foreach (Provider::find(Cart::getOrderProvidersIds($providers)) as $provider)
                {
                    $addresses[] = [
                        'order_id'         => $order->id,
                        'addressable_id'   => $provider->id,
                        'addressable_type' => Provider::class,
                        'address'          => $provider->address,
                        'phone'            => $provider->phone,
                    ];
                }

                DB::table('order_addresses')->insert($addresses);

                $order->update(['delivery_type' => 'location']);
            }

            if ($order->store_products_count == 0 && $request->delivery_type == 'location')
            {
                DB::table('order_addresses')->where('order_id', $order->id)->delete();

                DB::table('order_addresses')->insert([
                    'order_id' => $order->id,
                    'address'  => optional(optional($order->products->first())->city)->address,
                    'phone'    => optional(optional($order->products->first())->city)->phone,
                ]);

                $order->update(['delivery_type' => 'location']);
            }

            DB::commit();

            return ApiResponse::response(OrderDetailsResource::make($order));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiChangeUserOrderDates($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $order = Order::find($request->order_id);

            $start_date = $request->date('startDate')->format('Y-m-d');

            $end_date = $request->date('endDate')->format('Y-m-d');

            if ($request->date('startDate')->isPast() && ! $request->date('startDate')->isToday()) return Warning::sorryTheStartDateMustBeInFuture();

            if ($request->date('endDate')->isPast()) return Warning::sorryTheEndDateMustBeInFuture();

            if ($order->start_date->format('Y-m-d') == $start_date && $order->end_date->format('Y-m-d') == $end_date)
            {
                if ($order->start_time != $request->startTime && $order->end_time != $request->endTime)
                {
                    $order->update(['start_time' => $request->startTime, 'end_time' => $request->endTime]);
                }

                DB::commit();

                return ApiResponse::success();
            }

            $prices = Cart::getCartProductsPricesSum(col: 'price', order_products: $order->products);

            $subtotal = $prices * Cart::getRentDays($request);

            $summary = Cart::calcCartSummary($subtotal, $order->products);

            $order->update([
                'start_date'      => $request->startDate,
                'start_time'      => $request->startTime,
                'end_date'        => $request->endDate,
                'end_time'        => $request->endTime,
                'price'           => $summary->subtotal,
                'tax'             => $summary->tax,
                'total'           => $summary->total,
                'subtotal'        => $summary->subtotal + $summary->tax,
                'total_insurance' => $summary->total_insurance,
            ]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiCancelUserOrder($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            DB::table('orders')->where('id', $request->order_id)->update(['status' => OrderStatus::CANCELED]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiFilterUserOrders($request): JsonResponse
    {
        $query = Order::query()->where('status','!=',OrderStatus::CANCELED)->where('user_id', $request->user()->id);

        if ($request->filter != 'all') $query->where('status', $request->filter);

        if ($request->has('term') && $request->term != '')
        {
            $query->where(function (Builder $q) use ($request) {
                $q->where('order_no','LIKE',"%$request->term%");
                $q->orWhere('created_at','LIKE',"%$request->term%");
                $q->orWhere('total','LIKE',"%$request->term%");
            });
        }

        return ApiResponse::pagination($query->paginate(10),OrderResource::class);
    }

    public static function apiSetUserOrderPayCash($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            DB::table('orders')->where('id', $request->order_id)->update([
                'payment_method' => PaymentEnum::CASH, 'status' => OrderStatus::PROCESSING
            ]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiSetUserOrderPayByWallet($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if ($request->user()->is_wallet_empty) return Warning::sorryYourWalletBalanceIsNotEnoughToPay();

            Order::payWallet(Order::find($request->order_id));

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiSetUserPayInsurance($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $order = Order::find($request->order_id);

            $data = Payment::setPayCardHolder($order->total_insurance, $order->order_no, $request);

            $data['metadata']['order_id'] = $order->id;
            $data['metadata']['user_id'] = $request->user()->id;
            $data['metadata']['payment_method'] = 'online';

            $data['callback_url'] = Pay::setCallbackUrl('pay-insurance');

            $pay = Pay::charge($data);

            DB::commit();

            return ApiResponse::response(['payment_url' => $pay->payment_url]);
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiGetOrderStoresLocations($request): JsonResponse
    {
        $order = Order::find($request->order_id);

        return ApiResponse::response(Product::getProvidersAddresses($order->products));
    }

    public static function apiGetOrderUndertaking($request): JsonResponse
    {
        $undertaking = Undertaking::find($request->undertaking_id);

        return ApiResponse::response(UndertakingResource::make($undertaking));
    }

    public static function apiSetUserOrderUndertakingAction($request): JsonResponse
    {
        $undertaking = Undertaking::find($request->undertaking_id);

        if ($undertaking->status == 1) return Warning::sorryThisUndertakingAlreadyAccepted();

        $action = $request->action == 'accept';

        $undertaking->update(['status' => $action]);

        Notification::sendEmployeeUndertakingAction($undertaking, $action);

        return ApiResponse::success();
    }

    public static function apiSetUserThrowbackDemand($request): JsonResponse
    {
        $order = Order::find($request->order_id);

        if ($order->status == OrderStatus::CANCELED) return Warning::sorryThisOrderHasBeenCanceled();

        if ($order->status == OrderStatus::RETURNS) return Warning::sorryThisOrderAlreadySetToReturns();

        if ($order->status != OrderStatus::DELIVERED) return Warning::sorryThisOrderMustBeDelivered();

        Throwback::updateOrCreate(['user_id' => $order->user_id, 'order_id' => $order->id, 'reason' => $request->reason]);

        return ApiResponse::success('تم عمل طلب الاسترجاع بنجاح سيتم الرد عليك في حالة القبول او الرفض');
    }

    public static function apiSearch($request): JsonResponse
    {
        $orders = Order::search($request->term)->paginate(10);

        return ApiResponse::pagination($orders,EmployeeOrderResource::class);
    }

    public static function apiSetUserDelayPayCash($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            DB::table('orders')
                ->where('id', $request->order_id)
                ->update([
                    'is_delay_paid' => PaymentEnum::NEW_DELAY_CASH,
                ]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiSetUserDelayPayByWallet($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if ((int) $request->user()->wallet === 0) return Warning::sorryYourWalletBalanceIsNotEnoughToPay();

            $order = Order::find($request->order_id);

            if ((int) $order->user->wallet < (int) $order->delay_penalty) return Warning::sorryYourWalletBalanceIsNotEnoughToPay();

            $order->setOrderDelayPaid();

            Payment::payOrderDelay($order,'wallet');

            $order->user()->update(['wallet' => (int) $order->user->wallet - (int) $order->delay_penalty]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }
}
