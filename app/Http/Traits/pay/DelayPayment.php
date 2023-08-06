<?php

namespace App\Http\Traits\pay;

use App\Enums\PaymentEnum;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

trait DelayPayment
{
    public static function payDelaySuccess($request): string
    {
        app()->setLocale($request->lang);

        $payment = json_encode(self::setDelayPayment($request));

        return "<script type=text/javascript>payment.whenResponseBack('".$payment."');</script>";
    }

    public static function payDelayWebSuccess($request): RedirectResponse
    {
        $order_id = self::saveDelayProcess($request);

        if ($order_id == 0) return redirect()->to('/profile/orders');

        return redirect()->to('/profile/orders/'.$order_id.'/order-details');
    }

    public static function saveDelayProcess($request)
    {
        $meta = self::getMeta($request);

        $order = Order::find($meta->order_id);

        Payment::payOrderDelay($order, $request->id);

        $order->update(['payment_status' => PaymentEnum::PAID, 'is_delay_paid' => 1, 'delay_penalty' => 0]);

        return $meta->order_id;
    }

    public static function setDelayPayment($request): array
    {
        DB::beginTransaction();
        try
        {
            $order_id = self::saveDelayProcess($request);

            DB::commit();

            return self::paymentSuccessResponseForMobile($order_id);
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return self::paymentErrorResponseForMobile($e);
        }
    }
}
