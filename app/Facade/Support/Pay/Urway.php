<?php

namespace App\Facade\Support\Pay;

use App\Enums\PaymentEnum;
use App\Models\Payment;
use App\Repository\Contracts\PayInterface;
use Illuminate\Support\Facades\Http;

class Urway implements PayInterface
{
    public static function charge($arr): array
    {
        $response = Http::post(self::base(), self::getUrwayChargeData($arr))->object();

        return ['payment_url' => self::paymentUrl($response), 'error' => ''];
    }

    public static function getUrwayChargeData($arr): array
    {
        $redirect_url = $arr['redirect_url'] ?? root() . '/api/payments/success?orderId=' . $arr['trackid'];

        return [
            'trackid'       => $arr['trackid'],
            'terminalId'    => config('pay.urway.terminal_id'),
            'customerEmail' => $arr['user']['email'],
            'action'        => '1',  // action is always (1)
            'merchantIp'    => self::getServerIp(),
            'password'      => config('pay.urway.urway_password'),
            'currency'      => PaymentEnum::CURRENCY,
            'country'       => 'SA',
            'amount'        => $arr['amount'],
            'udf1'          => $arr['udf1'] ?? '',
            'udf2'          => $redirect_url, //Response page URL
            'udf3'          => $arr['udf3'] ?? '',
            'udf4'          => $arr['udf4'] ?? '',
            'udf5'          => $arr['udf5'] ?? '',
            'requestHash'   => self::generateHash($arr),  //generated Hash
        ];
    }

    public static function success($request): string
    {
        app()->setLocale($request->lang);

        $payment = json_encode(Payment::setPayment($request, '', ''));

        return "<script type=text/javascript>payment.whenResponseBack('" . $payment . "');</script>";
    }

    public static function paymentUrl($response): string
    {
        return (isset($response->targetUrl) && isset($response->payid))
            ? $response->targetUrl . '?paymentid=' . $response->payid
            : '';
    }

    private static function base(): string
    {
        $dev = app()->isLocal() ? '-dev' : '';

        return 'https://payments' . $dev . '.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest';
    }

    private static function getServerIp(): bool|array|string
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    private static function generateHash($arr): string
    {
        $txn_details = $arr['trackid'];

        $txn_details .= '|' . config('pay.urway.terminal_id');

        $txn_details .= '|' . config('pay.urway.urway_password');

        $txn_details .= '|' . config('pay.urway.merchant_secret_key');

        $txn_details .= '|' . $arr['amount'];

        $txn_details .= '|' . PaymentEnum::CURRENCY;

        return hash('sha256', $txn_details);
    }
}
