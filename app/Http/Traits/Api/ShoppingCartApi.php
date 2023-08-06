<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Tools\Time;
use App\Enums\{OrderStatus, PaymentEnum};
use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Facade\Support\Tools\Percentage;
use App\Http\Resources\{User\ApplyCouponResource, User\ShoppingCartResource};
use App\Models\{Address, Cart, Order, OrderProduct, Product, Provider, User};
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait ShoppingCartApi
{
    public static function apiGetUserCartContent(): JsonResponse
    {
        $cart = Cart::calcCartSummary();

        return ApiResponse::response(ShoppingCartResource::make($cart));
    }

    public static function apiAddProductToCart($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $has_address = true;

            $cart = Cart::firstOrcreate(['user_id' => $request->user()->id]);

            $product = Product::find($request->product_id);

            if (!$product) return Warning::sorryThisProductIsNotAvailable();

            if ($product->qty == 0) return Warning::sorryThisProductIsNotAvailable();

            if (!$request->user()->address || !$request->user()->address_id) $has_address = false;

            if (!$has_address) return ApiResponse::response(['cart_id' => 0, 'same_city' => false, 'has_address' => false]);

            if ($product->city_id !== $request->user()->address->city_id) return ApiResponse::response(['cart_id' => 0, 'same_city' => true, 'has_address' => true]);

            $check = DB::table('cart_product')->where('cart_id', $cart->id)->where('product_id', $request->product_id)->count();

            if ($check) return Warning::productAlreadyAddedToCart();

            $price = $product->has_offer ? $product->offer_value : $product->price;

            $cart->products()->attach($request->product_id, [
                'ownership'  => $product->type,
                'hour_price' => $product->hour_price,
                'qty'        => $request->quantity,
                'price'      => $price,
            ]);

            DB::commit();

            return ApiResponse::response(['cart_id' => $cart->id, 'same_city' => false, 'has_address' => true]);
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiRemoveProductFromCart($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            DB::table('cart_product')
                ->where('cart_id', $request->user()->cart->id)
                ->where('product_id', $request->product_id)
                ->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiCompleteUserOrder($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if ($request->type == 'day') {
                if ($request->date('startDate')->diffInDays($request->date('endDate')) == 0) return Warning::sorryTheTimeBetweenStartDateAndEndDateMustBe24Hours();

                if (!$request->date('endDate')->isAfter($request->date('startDate'))) return Warning::sorryTheEndDateMustBeAfterStartDate();
            }

            $subtotal = self::getFinalSubtotal($request);

            $summary = Cart::calcCartSummary(subtotal: $subtotal, col: $request->type);

            $orderData = self::getOrderData($request, $summary);

            if ($request->is_applied) {
                $apply_coupon = Cart::calcCoupon($request, $subtotal);

                $orderData['coupon'] = $request->coupon;
                $orderData['discount'] = $apply_coupon->discount;
                $orderData['total'] = $apply_coupon->total;
            }

            $order = Order::create($orderData);

            $order->products()->sync(self::getOrderProducts($request));

            self::createOrderAddressWithProviders($request, $order, $summary->tax);

            DB::table('cart_product')->where('cart_id', $request->user()->cart->id)->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiApplyCoupon($request): JsonResponse
    {
        $calc_coupon = self::getCalculatedCouponWithDates($request);

        return ApiResponse::response(['discount' => $calc_coupon->discount, 'total' => $calc_coupon->total]);
    }

    public static function apiChangeProductQty($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            DB::table('cart_product')
                ->where('cart_id', $request->user()->cart->id)
                ->where('product_id', $request->product_id)
                ->update(['qty' => $request->quantity]);

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiValidateShoppingCartDates($request): JsonResponse
    {
        if (self::checkForHours($request)) return Warning::sorryTheTimeBetweenStartDateAndEndDateMustBe24Hours();

        return ApiResponse::success();
    }

    public static function apiCalculateDatesDays($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if (!$request->filled('startDate') && !$request->filled('endDate')) return ApiResponse::success();

            $subtotal = Cart::getCartProductsPricesSum('price') * self::getRentDays($request);

            DB::commit();

            return ApiResponse::response(ShoppingCartResource::make(Cart::calcCartSummary($subtotal)));
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiCalculateDatesHours($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if (!$request->filled('startDate') && !$request->filled('endDate')) return ApiResponse::success();

            $subtotal = self::getCartProductsPricesSum('hour_price') * self::getFullDatesDiff($request);

            DB::commit();

            return ApiResponse::response(ShoppingCartResource::make(Cart::calcCartSummary($subtotal)));
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiApplyCouponWithDates($request): JsonResponse
    {
        $subtotal = self::getCartProductsPricesSum('price') * self::getRentDays($request);

        $summary = Cart::calcCartSummary($subtotal);

        if (!$request->filled('coupon')) return ApiResponse::response(ShoppingCartResource::make($summary));

        $calc_coupon = self::getCalculatedCouponWithDates($request);

        return ApiResponse::response(ApplyCouponResource::make((object)['coupon' => $calc_coupon, 'summary' => $summary]));
    }

    // ================================================================================
    // ================================================================================

    private static function getOrderProducts($request): array
    {
        $arr = [];

        foreach ($request->user()->cart->products as $product) {
            if ($product->qty == 0) continue;

            $price = (int)$product->price * (int)$product->cart_qty;

            $arr[$product->id] = [
                'type'                 => $product->type,
                'type_id'              => $product->type_id,
                'product_rate'         => $product->rate,
                'product_rates_count'  => $product->rates_count,
                'product_qty'          => $product->cart_qty,
                'product_section'      => $product->section->name,
                'product_city_name'    => $product->city->name,
                'product_section_icon' => $product->section->icon,
                'product_category'     => $product->category->name,
                'product_name'         => $product->name,
                'product_image'        => $product->first_image_url,
                'product_price'        => $price,
                'product_offer'        => round(Percentage::total($product->offer, $price)),
            ];
        }

        return $arr;
    }

    public static function getOrderProviders($providers, $order, $order_tax): array
    {
        $arr = [];

        $providers_ids = self::getOrderProvidersIds($providers);

        $rental_has_products = $order->rental_products_count > 0 ? 1 : 0;

        $tax = round($order_tax / (count($providers_ids) + $rental_has_products));

        foreach ($providers_ids as $id) {
            $arr[$id] = [
                'provider_order_price'           => $order->getProviderOrderPrice($id),
                'provider_order_tax'             => (string)$tax,
                'provider_order_total_insurance' => (string)$order->getProviderOrderTotalInsurance($id),
                'provider_order_subtotal'        => (string)$order->getProviderOrderSubtotal($id, $tax),
                'provider_order_discount'        => (string)$order->getProviderOrderDiscount($id),
                'provider_order_total'           => (string)$order->providerOrderTotal($id, $tax),
            ];
        }

        return $arr;
    }

    private static function getOrderData($request, $summary): array
    {
        return [
            'user_id'         => $request->user()->id,
            'username'        => $request->user()->full_name,
            'order_no'        => create_rand_numbers(6),
            'start_date'      => $request->startDate,
            'start_time'      => $request->date('startTime')->format('H:i'),
            'end_date'        => $request->endDate,
            'end_time'        => $request->date('endTime')->format('H:i'),
            'status'          => OrderStatus::PENDING,
            'payment_status'  => PaymentEnum::DELAYED,
            'address_id'      => $request->address_id,
            'delivery_type'   => 'address',
            'price'           => $summary->subtotal,
            'tax'             => $summary->tax,
            'total'           => $summary->total,
            'subtotal'        => $summary->subtotal + $summary->tax,
            'total_insurance' => $summary->total_insurance,
        ];
    }

    public static function getOrderProvidersIds($providers): array
    {
        return array_unique($providers->pluck('type_id')->toArray());
    }

    private static function createOrderAddressWithProviders($request, $order, $order_tax): void
    {
        if ($request->delivery_type == 'address') {
            $address = Address::find($request->address_id);

            DB::table('order_addresses')->insert([
                'order_id'         => $order->id,
                'addressable_id'   => $request->user()->id,
                'addressable_type' => User::class,
                'address'          => $address->full_address,
                'phone'            => $address->phone,
            ]);
        }

        if ($order->store_products_count > 0) {
            $providers = OrderProduct::whereType(Provider::class)->whereOrderId($order->id)->get();

            $order->providers()->sync(self::getOrderProviders($providers, $order, $order_tax));

            if ($request->delivery_type == 'location') {
                $addresses = [];

                foreach (Provider::find(self::getOrderProvidersIds($providers)) as $provider) {
                    $addresses[] = [
                        'order_id'         => $order->id,
                        'addressable_id'   => $provider->id,
                        'addressable_type' => Provider::class,
                        'address'          => $provider->address,
                        'phone'            => $provider->phone,
                    ];
                }

                DB::table('order_addresses')->insert($addresses);
            }
        }
    }

    private static function checkForHours($request): bool
    {
        if ($request->date('startDate')->isToday() && $request->date('endDate')->isToday()) return self::getFullDatesDiff($request) > 24;

        return false;
    }

    public static function getFullDatesDiff($request): int
    {
        $startTimeDate = Time::createFullDatetime($request->startDate, $request->startTime);

        $endTimeDate = Time::createFullDatetime($request->endDate, $request->endTime);

        return $endTimeDate->diffInHours($startTimeDate);
    }

    public static function getFinalSubtotal($request): float
    {
        if ($request->type == 'hour') return self::getCartProductsPricesSum('hour_price') * self::getFullDatesDiff($request);

        $sum = self::getCartProductsPricesSum('price');

        return $sum * self::getRentDays($request);
    }
}
