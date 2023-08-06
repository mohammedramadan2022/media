<?php

namespace App\Http\Traits\pay;

use App\Facade\Support\Pay\Moyasar;

trait PaymentHelper
{
    public static function paymentResponseForMobile($success, $id, $error = '', $message = 'success'): array
    {
        return ['success' => $success, 'order_id' => $id, 'error' => $error, 'message' => $message];
    }

    private static function paymentSuccessResponseForMobile($id = 0, $message = 'success'): array
    {
        return self::paymentResponseForMobile(true, $id, '', $message);
    }

    private static function paymentErrorResponseForMobile($error): array
    {
        return self::paymentResponseForMobile(false, 0, getFormattedException($error));
    }

    // Helpers

    private static function getMeta($request): object|int
    {
        $response = Moyasar::fetch($request->id);

        return (object) $response->metadata;
    }

    public static function setPayCardHolder($amount, $desc, $request): array
    {
        return [
            'amount'      => $amount * 100,
            'description' => $desc,
            'name'        => $request->card_holder,
            'number'      => $request->card_numbers,
            'month'       => $request->card_month,
            'year'        => $request->card_year,
            'cvc'         => $request->card_cvv,
        ];
    }
}
