<?php

namespace App\Facade\Support\Pay;

use App\Facade\Support\Core\ApiResponse;
use App\Models\Payment;
use App\Repository\Contracts\PayInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TapCompany implements PayInterface
{
    public static function charge($arr): array
    {
        $data = self::getTapPayChargeData($arr);

        $response = Http::withToken(config('pay.payment_key'))->post(self::base(), $data)->json();

        if (isset($response['error']))
        {
            return ['payment_url' => '', 'error' => $response['error']];
        }

        return ['payment_url' => self::paymentUrl($response), 'error' => ''];
    }

    public static function getTapPayChargeData($arr): array
    {
        $user = $arr['user'];

        $data['amount'] = $arr['amount'];
        $data['currency'] = $arr['currency'];
        $data['threeDSecure'] = true;
        $data['save_card'] = false;
        $data['description'] = 'Payment Subscription';
        $data['statement_descriptor'] = 'Sample';
        $data['metadata'] = $arr['metadata'] ?? [];

        $data['receipt']['email'] = true;
        $data['receipt']['sms'] = false;

        $data['customer']['first_name'] = $user->name;
        $data['customer']['middle_name'] = '';
        $data['customer']['last_name'] = '';
        $data['customer']['email'] = $user->email;
        $data['customer']['phone']['country_code'] = '966';
        $data['customer']['phone']['number'] = $user->phone;
        $data['source']['id'] = 'src_card'; // src_card => visa, src_kw.knet => default
        $data['redirect']['url'] = $arr['redirect'];

        return $data;
    }

    public static function tapPayChargeId($tap_id)
    {
        $token = config('pay.payment_key');

        $url = "https://api.tap.company/v2/charges/$tap_id";

        return Http::withToken($token)->get($url)->json();
    }

    public static function getStatus($code = null)
    {
        $codes = [
            '000' => trans('pay.000'),
            '001' => trans('pay.001'),
            '100' => trans('pay.100'),
            '200' => trans('pay.200'),
            '301' => trans('pay.301'),
            '302' => trans('pay.302'),
            '303' => trans('pay.303'),
            '304' => trans('pay.304'),
            '401' => trans('pay.401'),
            '402' => trans('pay.402'),
            '403' => trans('pay.403'),
            '404' => trans('pay.404'),
            '405' => trans('pay.405'),
            '406' => trans('pay.406'),
            '407' => trans('pay.407'),
            '408' => trans('pay.408'),
            '501' => trans('pay.501'),
            '502' => trans('pay.502'),
            '503' => trans('pay.503'),
            '504' => trans('pay.504'),
            '505' => trans('pay.505'),
            '506' => trans('pay.506'),
            '507' => trans('pay.507'),
            '508' => trans('pay.508'),
            '509' => trans('pay.509'),
            '510' => trans('pay.510'),
            '511' => trans('pay.511'),
            '512' => trans('pay.512'),
            '513' => trans('pay.513'),
            '514' => trans('pay.514'),
            '515' => trans('pay.515'),
            '601' => trans('pay.601'),
            '701' => trans('pay.701'),
            '702' => trans('pay.702'),
            '703' => trans('pay.703'),
            '704' => trans('pay.704'),
            '801' => trans('pay.801'),
            '901' => trans('pay.901'),
        ];

        if (isset($code)) {
            return $codes[$code];
        }

        return $codes;
    }

    public static function paymentType($request): string
    {
        DB::beginTransaction();
        try
        {
            $response = self::tapPayChargeId($request->tap_id);

            if (isset($response['errors'])) {
                return self::error($response);
            }

            $res = self::success($request, $response);

            DB::commit();

            return $res;
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function error($response): string
    {
        $payment['success'] = 0;
        $payment['order_id'] = 0;
        $payment['error'] = $response['errors'][0]['description'];
        $payment['code'] = $response['errors'][0]['code'];

        return '<script type=text/javascript>'.json_encode($payment).'</script>';
    }

    private static function success($request, $response): string
    {
        app()->setLocale($request->lang);

        $res = Payment::setPayment($response);

        return "<script type=text/javascript>payment.whenResponseBack('".json_encode($res)."');</script>";
    }

    public static function base(): string
    {
        return 'https://api.tap.company/v2/charges';
    }

    public static function paymentUrl($response)
    {
        return $response['transaction']['url'];
    }
}
