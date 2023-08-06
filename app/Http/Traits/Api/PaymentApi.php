<?php

namespace App\Http\Traits\Api;

use App\Enums\PaymentEnum;
use App\Facade\Support\Core\{ApiResponse, Pay, Warning};
use App\Models\Order;
use Illuminate\Http\JsonResponse;

trait PaymentApi
{
    public static function setUserOrderPay($request): JsonResponse
    {
        $order = Order::find($request->order_id);

        $data = self::setPayCardHolder($order->total, $order->product_name, $request);

        $data['metadata']['order_id'] = $order->id;
        $data['metadata']['user_id'] = $request->user()->id ?? 1;
        $data['metadata']['payment_method'] = PaymentEnum::VISA;

        $data['callback_url'] = Pay::setCallbackUrl('pay');

        $pay = Pay::charge($data);

        if ($pay->payment_url == '') return Warning::sorryPaymentProcessFailed();

        return ApiResponse::response(['payment_url' => $pay->payment_url]); // return payment url;
    }

    public static function setUserDelayPay($request): JsonResponse
    {
        $order = Order::find($request->order_id);

        $data = self::setPayCardHolder($order->delay_penalty, $order->product_name, $request);

        $data['metadata']['order_id'] = $order->id;
        $data['metadata']['user_id'] = $request->user()->id ?? 0;
        $data['metadata']['payment_method'] = PaymentEnum::VISA;

        $data['callback_url'] = Pay::setCallbackUrl('pay-delay');

        $pay = Pay::charge($data);

        if (isset($pay->error) && $pay->payment_url == '') return ApiResponse::warning($pay->error);

        if ($pay->payment_url == '') return Warning::sorryPaymentProcessFailed();

        return ApiResponse::response(['payment_url' => $pay->payment_url]);
    }
}
