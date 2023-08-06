<?php

namespace App\Facade\Support\Pay;

use Illuminate\Support\Facades\Http;

class PayTabs
{
    private static function getPayTabsResponse($code): array|string
    {
        $codes = [
            '4001' => 'Missing parameters.',
            '4002' => 'Invalid Credentials.',
            '4003' => 'There are no transactions available.',
            '0404' => 'You don’t have permissions.',
            '481'  => 'This transaction may be suspicious, your bank holds for further confirmation. Payment Provider has rejected this transaction due to suspicious activity; Your bank will reverse the dedicated amount to your card as per their policy.',
            '100'  => 'Payment is completed Successfully.',
        ];

        if (isset($code)) {
            return $codes[$code];
        }

        return $codes;
    }

    public static function payTabsPayment($payment, $request): array
    {
        $data['merchant_email'] = $payment['email'];
        $data['secret_key'] = $payment['key'];
        $data['transaction_id'] = $request->transaction_id;
        $data['order_id'] = $request->order_id;

        $response = Http::withHeaders(['content-type: multipart/form-data'])->post('https://www.paytabs.com/apiv2/verify_payment_transaction', $data)->object();

        $_res = [];

        return [
            'msg'    => self::getPayTabsResponse($response->response_code),
            'code'   => $response->response_code,
            'result' => $_res
        ];
    }
}
