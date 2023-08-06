<?php

namespace App\Http\Traits\pay;

use App\Enums\PaymentEnum;
use App\Facade\Support\Pay\Moyasar;
use App\Models\Order;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

trait OnlinePayment
{
    public static function paySuccess($request): string
    {
        app()->setLocale($request->lang);

        $payment = json_encode(self::setPayment($request));

        return "<script type=text/javascript>payment.whenResponseBack('".$payment."');</script>";
    }

    public static function payWebSuccess($request): RedirectResponse
    {
        $order_id = self::savePaymentProcess($request, PaymentEnum::VISA);

        $order = Order::find($order_id);

        if ($order_id == 0) return redirect()->to('/profile/orders');

        return redirect()->to('/profile/orders/'.$order->order_no.'/order-details');
    }

    public static function savePaymentProcess($request, $method)
    {
        $meta = self::getMeta($request);

        $transaction_id = $method == PaymentEnum::VISA ? $request->id : $method;

        if ($request->status == Moyasar::SUCCESS) Order::pay($meta->order_id, $method, $transaction_id);

        return $meta->order_id;
    }

    public static function setPayment($request): array
    {
        DB::beginTransaction();
        try
        {
            $order_id = self::savePaymentProcess($request,PaymentEnum::VISA);

            DB::commit();

            return self::paymentSuccessResponseForMobile($order_id);
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return self::paymentErrorResponseForMobile(getFormattedException($e));
        }
    }
}
