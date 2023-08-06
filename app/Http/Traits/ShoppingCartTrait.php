<?php

namespace App\Http\Traits;

use App\Enums\OrderStatus;
use App\Facade\Support\Tools\Percentage;
use App\Http\Scopes\ShoppingCartScopes;
use App\Http\Traits\Api\ShoppingCartApi;
use App\Models\{Admin, Cart, CartProduct, Coupon, Order, OrderProduct, Product};
use Illuminate\Database\Eloquent\Builder;

trait ShoppingCartTrait
{
    use BasicTrait, ShoppingCartScopes, ShoppingCartApi;

    public static function calcCartSummary($subtotal = 0, $products = [], $col = 'price'): object
    {
        $with = ['translation', 'section.translation', 'category.translation', 'city', 'city.translation', 'images'];

        $_products = count($products) > 0 ? $products : (request()->user()->cart->products->load($with) ?? []);

        $data['products'] = $_products;
        $data['subtotal'] = $subtotal != 0 ? $subtotal : self::getSubtotal($_products, $col);
        $data['total_insurance'] = count($_products) > 0 ? $_products->sum('insurance') : 0;
        $data['tax'] = round(Percentage::discount(getSetting('app_tax'), $data['subtotal']));
        $data['total'] = $data['subtotal'] + $data['total_insurance'] + $data['tax'];

        return (object) $data;
    }

    public static function calcCoupon($request, $subtotal = 0): object
    {
        $summary = Cart::calcCartSummary($subtotal);

        $coupon = Coupon::whereName($request->coupon)->first();

        $coupon_ownership = $coupon->couponable_type == Admin::class ? null : $coupon->couponable_type;

        $cart_products = $request->user()->cart->products()->where('type', $coupon_ownership)->get();

        $owner_subtotal = (self::getSubtotal($cart_products) * self::getRentDays($request)) + $summary->tax;

        $discount = Percentage::discount($coupon->value, $owner_subtotal);

        return (object) ['discount' => round($discount, 1), 'total' => $owner_subtotal - $discount];
    }

    public static function getCartLocationAddresses(): array
    {
        return Product::getProvidersAddresses(optional(request()->user()->cart)->products);
    }

    public static function validateShoppingCartDates($request, $products_id): bool
    {
        $orderProductQuery = OrderProduct::query();

        $orderProductQuery->whereHas('order', fn ($query) => $query->where('status', OrderStatus::PENDING));

        $orderProductQuery->whereIn('product_id', $products_id);

        $orders_ids = $orderProductQuery->select('order_id')->pluck('order_id')->toArray();

        $unique = array_unique($orders_ids);

        if (count($unique) == 0) return false;

        $checkQuery = Order::query();

        $checkQuery->where(function (Builder $query) use ($request, $unique) { // equal
            $query->whereIn('id', $unique)->pending()->where('start_date', $request->startDate.' 00:00:00');
            $query->where('end_date', $request->startDate.' 00:00:00');
        });

        $checkQuery->orWhere(function (Builder $qu) use ($request, $unique) { // between
            $qu->whereIn('id', $unique)->pending()->where('start_date', '<=', $request->startDate.' 00:00:00');
            $qu->where('end_date', '>', $request->startDate.' 00:00:00');
        });

        $checkQuery->orWhere(function (Builder $que) use ($request, $unique) { // before start_date
            $que->whereIn('id', $unique)->pending()->where('start_date', '>', $request->startDate.' 00:00:00');
            $que->where('start_date', '<', $request->endDate.' 00:00:00');
        });

        return $checkQuery->count() > 0;
    }

    private static function getSubtotal($products, $col = 'price')
    {
        $subtotal = 0;

        foreach ($products as $product) {
            $price = $product->$col * $product->cart_qty;

            if ($product->has_offer != 0) {
                $subtotal = $subtotal + round(Percentage::total($product->offer, $price));
            } else {
                $subtotal = $subtotal + (int) $price;
            }
        }

        return $subtotal;
    }

    public static function getRentDays($request): int
    {
        return $request->date('startDate')->diffInDays($request->date('endDate'));
    }

    public static function getCalculatedCouponWithDates($request): object
    {
        $price = self::getCartProductsPricesSum('price');

        $subtotal = $price * self::getRentDays($request);

        return Cart::calcCoupon($request, $subtotal);
    }

    public static function getCartProductsPricesSum($col, $order_products = []): float|int
    {
        $_prices = [];

        $_products = count($order_products) > 0 ? $order_products : CartProduct::whereCartId(request()->user()->cart->id)->get();

        foreach ($_products as $product) {
            $_prices[] = count($order_products) > 0
                ? ($product->$col * $product->pivot->product_qty)
                : ($product->$col * $product->qty);
        }

        return array_sum($_prices);
    }
}
