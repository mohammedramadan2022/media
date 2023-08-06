<?php

namespace App\Http\Traits;

use App\Enums\{OrderStatus, PaymentEnum};
use App\Http\Resources\User\CityResource;
use App\Http\Scopes\OrderScopes;
use App\Http\Traits\Api\OrderApi;
use App\Models\{Coupon, Provider, Notification, Order, OrderProduct, Product};
use Illuminate\Support\Facades\DB;

trait OrderTrait
{
    use BasicTrait, OrderScopes, OrderApi;

    public static function statuses($key = '')
    {
        $arr = [
            OrderStatus::PENDING            => trans('back.pending'),
            OrderStatus::ACCEPTED           => trans('back.accepted'),
            OrderStatus::REJECTED           => trans('back.rejected'),
            OrderStatus::PROCESSING         => trans('back.processing'),
            OrderStatus::READY_FOR_DELIVERY => trans('back.ready_for_delivery'),
            OrderStatus::IN_DELIVERY        => trans('back.in_delivery'),
            OrderStatus::PICK_UP            => trans('back.ready_for_pick_up'),
            OrderStatus::DELIVERED          => trans('back.delivered'),
            OrderStatus::RECEIVED           => trans('back.received'),
//            OrderStatus::RETURNS            => trans('back.returns'),
            OrderStatus::NOT_RECEIVED       => trans('back.notReceived'),
            OrderStatus::CANCELED           => trans('back.canceled'),
        ];

        return $key !== '' ? $arr[$key] : $arr;
    }

    public static function pay($order_id, $method, $has_insurance = false, $id = 0): void
    {
        DB::transaction(function () use ($order_id, $method, $has_insurance, $id) {
            $order = Order::find($order_id);

            $transaction_id = $id != 0 ? $id : $method;

            $payment = $order->payment()->create([
                'user_id'        => $order->user_id,
                'username'       => $order->user->full_name,
                'amount'         => $has_insurance ? $order->total_insurance : $order->total,
                'currency'       => PaymentEnum::CURRENCY,
                'transaction_id' => $transaction_id,
            ]);

            $order->update([
                'status'           => OrderStatus::PROCESSING,
                'payment_status'   => PaymentEnum::PAID,
                'payment_method'   => $method,
                'final_accept'     => 1,
                'is_rental_accept' => 1,
                'payment_id'       => $payment->id,
            ]);

            self::updateOrderProductsQty($order);

            Notification::sendUserOrderPayedOnlineSuccessfully($order);
        });
    }

    public static function payCash($order_id): void
    {
        self::pay(order_id: $order_id, method: PaymentEnum::CASH);
    }

    public static function payVisa($order_id, $id): void
    {
        self::pay(order_id: $order_id, method: PaymentEnum::VISA, has_insurance: true, id: $id);
    }

    public static function payWallet($order): void
    {
        self::pay(order_id: $order->id, method: PaymentEnum::WALLET);

        $order->user()->update(['wallet' => (int)$order->user->wallet - (int)$order->total]);
    }

    public static function saveInsurance($order_id, $id): void
    {
        $order = Order::find($order_id);

        $order->payment()->create([
            'user_id'        => $order->user_id,
            'amount'         => $order->total_insurance,
            'currency'       => PaymentEnum::CURRENCY,
            'transaction_id' => $id,
        ]);
    }

    public static function updateOrderProductsQty($order): void
    {
        foreach ($order->products as $order_product) {
            DB::table('products')
                ->where('id', $order_product->id)
                ->decrement('qty', $order_product->pivot->product_qty);
        }
    }

    public static function getRentalObject($order): array
    {
        $rental = [];

        if ($order->rental_products_count > 0) {
            $city = $order->rental_products->first()->product->city;

            $rental = [
                'name'    => trans('back.rental'),
                'phone'   => $city->phone ? getFormattedPhone($city->phone) : '',
                'city'    => CityResource::make($city),
                'address' => $city->address,
            ];
        }

        return $rental;
    }

    public static function updateOrderBy($status, $order)
    {
        return match ($status) {
            OrderStatus::PENDING                 => $order->updateOrderStatus(OrderStatus::PENDING),
            OrderStatus::ACCEPTED                => $order->beAccepted(),
            OrderStatus::REJECTED                => $order->rejected(),
            OrderStatus::PROCESSING              => $order->updateOrderStatus(OrderStatus::PROCESSING),
            OrderStatus::PROCESSED               => $order->updateOrderStatus(OrderStatus::PROCESSED),
            OrderStatus::REVIEWED                => $order->updateOrderStatus(OrderStatus::REVIEWED),
            OrderStatus::CANCELED                => $order->updateOrderStatus(OrderStatus::CANCELED),
            OrderStatus::READY_FOR_DELIVERY      => $order->updateOrderStatus(OrderStatus::READY_FOR_DELIVERY),
            OrderStatus::REJECTED_FROM_WAREHOUSE => $order->updateOrderStatus(OrderStatus::REJECTED_FROM_WAREHOUSE),
            OrderStatus::IN_DELIVERY             => $order->updateOrderStatus(OrderStatus::IN_DELIVERY),
            OrderStatus::RETRIEVING              => $order->updateOrderStatus(OrderStatus::RETRIEVING),
            OrderStatus::DELIVERED               => $order->updateOrderStatus(OrderStatus::DELIVERED),
            OrderStatus::RECEIVED                => $order->updateOrderStatus(OrderStatus::RECEIVED),
            OrderStatus::NOT_RECEIVED            => $order->updateOrderStatus(OrderStatus::NOT_RECEIVED),
            OrderStatus::REJECTED_BY_PROVIDER    => $order->updateOrderStatus(OrderStatus::REJECTED_BY_PROVIDER),
            OrderStatus::DELIVERY_TO_WAREHOUSE   => $order->updateOrderStatus(OrderStatus::DELIVERY_TO_WAREHOUSE),
            OrderStatus::DELIVERED_TO_MERCHANT   => $order->updateOrderStatus(OrderStatus::DELIVERED_TO_MERCHANT),
            OrderStatus::PICK_UP                 => $order->updateOrderStatus(OrderStatus::PICK_UP),
            OrderStatus::RETURNS                 => $order->updateOrderStatus(OrderStatus::RETURNS),
        };
    }

    public function getProviderOrderDiscount($id)
    {
        return $this->isCurrentProviderCoupon($id) ? $this->discount : 0;
    }

    public function getProviderOrderPrice($id): string
    {
        return $this->products
            ->filter(function ($pro) use ($id) {
                return $pro->type == "App\Models\Provider" && $pro->type_id == $id;
            })
            ->sum('price');
    }

    public function getProviderOrderSubtotal($id, $tax): string
    {
        return (int)$this->getProviderOrderPrice($id) + (int)$this->getProviderOrderTotalInsurance($id) + (int)$tax;
    }

    public function getProviderOrderTotalInsurance($id)
    {
        $ids = OrderProduct::whereType(Provider::class)
            ->whereTypeId($id)
            ->whereOrderId($this->id)
            ->get()
            ->pluck('product_id')
            ->toArray();

        return Product::whereType(Provider::class)->whereIn('id', $ids)->whereTypeId($id)->sum('insurance');
    }

    public function providerOrderTotal($id, $tax)
    {
        return $this->getProviderOrderSubtotal($id, $tax) - $this->getProviderOrderDiscount($id);
    }

    public function isCurrentProviderCoupon($provider_id): bool
    {
        return Coupon::query()
                ->where('couponable_type',Provider::class)
                ->where('couponable_id', $provider_id)
                ->where('name', $this->coupon)
                ->count() > 0;
    }

    public function canChangeStatusToPending($status): bool
    {
        return $status == OrderStatus::PENDING && $this->is_payed && $this->provider_id;
    }

    public function canPayOrderByUserWallet($payment_method): bool
    {
        return $payment_method == PaymentEnum::WALLET && $this->user->is_wallet_empty;
    }

    public function isNeedToSetProviderFirst($status): bool
    {
        return is_null($this->provider_id) && $status == OrderStatus::PICK_UP;
    }

    // admin order change status;

    public function beAccepted(): void
    {
        $this->update(['is_rental_accept' => 1]);

        if ($this->store_products_count == 0) {
            $this->update([
                'status'         => OrderStatus::ACCEPTED,
                'payment_status' => $this->payment_status ?? PaymentEnum::DELAYED,
                'final_accept'   => 1,
            ]);
        }
    }

    public function beRejected(): void
    {
        $this->update([
            'status'           => OrderStatus::REJECTED,
            'is_rental_accept' => false,
            'payment_status'   => PaymentEnum::NOT_PAID,
        ]);
    }

    public function beFinalAccepted(): void
    {
        $this->update([
            'status'         => OrderStatus::ACCEPTED,
            'final_accept'   => true,
            'payment_status' => PaymentEnum::WAIT_TO_PAY,
        ]);
    }

    public function updateOrderStatus($status): void
    {
        $this->update(['status' => $status]);
    }

    public function bePending(): void
    {
        $this->update([
            'status'           => OrderStatus::PENDING,
            'is_rental_accept' => null,
            'final_accept'     => 0,
        ]);
    }

    public function setOrderDelayPaid(): bool
    {
        return $this->update([
            'is_delay_paid'  => PaymentEnum::ACCEPTED_DELAY_CASH,
            'delay_penalty'  => 0,
            'payment_status' => PaymentEnum::PAID,
        ]);
    }

    public function hasOutOfStockProducts(): bool
    {
        return count(array_filter($this->products->map->qty->toArray())) == 0;
    }

    public function beRejectedForProvider($order): void
    {
        $this->update([
            'price'           => (int)$this->price - (int)$order->provider_order_price,
            'total_insurance' => (int)$this->total_insurance - (int)$order->provider_order_total_insurance,
            'tax'             => (int)$this->tax - (int)$order->provider_order_tax,
            'subtotal'        => (int)$this->subtotal - (int)$order->provider_order_tax,
            'discount'        => (int)$this->discount - (int)$order->provider_order_discount,
            'total'           => (int)$this->total - (int)$order->provider_order_total,
        ]);
    }
}
