<?php

namespace App\Http\Traits\pay;

use App\Enums\OrderStatus;
use App\Enums\PaymentEnum;
use App\Facade\Support\Pay\Moyasar;
use App\Models\Order;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

trait InsurancePayment
{
    public static function payInsuranceSuccess($request): string
    {
        app()->setLocale($request->lang);

        $payment = json_encode(self::setPayInsurancePayment($request));

        return "<script type=text/javascript>payment.whenResponseBack('".$payment."');</script>";
    }

    public static function payInsuranceWebSuccess($request): RedirectResponse
    {
        $order_id = self::savePaymentInsuranceProcess($request);

        return redirect()->to('/profile/orders/'.$order_id.'/order-details');
    }

    public static function savePaymentInsuranceProcess($request)
    {
        $meta = self::getMeta($request);

        if ($request->status == Moyasar::SUCCESS)
        {
            Order::saveInsurance($meta->order_id, $request->id);

            DB::table('orders')
                ->where('id', $meta->order_id)
                ->update([
                    'payment_method' => PaymentEnum::CASH,
                    'final_accept'   => 1,
                    'status'         => OrderStatus::PROCESSING,
                ]);
        }

        return $meta->order_id;
    }

    public static function setPayInsurancePayment($request): array
    {
        DB::beginTransaction();
        try
        {
            self::savePaymentInsuranceProcess($request);

            DB::commit();

            return self::paymentSuccessResponseForMobile();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return self::paymentErrorResponseForMobile(getFormattedException($e));
        }
    }
}
