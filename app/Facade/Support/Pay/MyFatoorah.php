<?php

namespace App\Facade\Support\Pay;

use App\Enums\PaymentEnum;
use App\Facade\Support\Core\ApiResponse;
use App\Models\Payment;
use App\Repository\Contracts\PayInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{DB, Http};
use Illuminate\Support\Env;

class MyFatoorah implements PayInterface
{
    public static function charge($arr): JsonResponse|array
    {
        $url = self::base('/v2/ExecutePayment');

        $data = self::getFatoorahChargeData($arr);

        $response = Http::withToken(config('pay.payment_key'))->post($url, $data)->object();

        if (isset($response->ValidationErrors)) {
            return ApiResponse::validation('error', ['payment_url' => '', 'error' => $response->ValidationErrors]);
        }

        return ['payment_url' => $response->Data->PaymentURL, 'error' => ''];
    }

    public static function getFatoorahChargeData($arr): array
    {
        $user = $arr['user'];

        $data['PaymentMethodId'] = $arr['payment_method_id'];
        $data['CustomerName'] = $user->full_name;
        $data['DisplayCurrencyIso'] = PaymentEnum::CURRENCY;
        $data['MobileCountryCode'] = $user->country_code;
        $data['CustomerMobile'] = $user->phone;
        $data['CustomerEmail'] = $user->email;
        $data['InvoiceValue'] = $arr['total'];
        $data['CallBackUrl'] = $arr['callBackUrl'];
        $data['ErrorUrl'] = $arr['errorUrl'];
        $data['Language'] = 'en';
        $data['UserDefinedField'] = self::getUserDefinedFields($user, $arr);

        $data['SupplierCode'] = 0;
        $data['InvoiceItems'][0]['ItemName'] = 'Course';
        $data['InvoiceItems'][0]['Quantity'] = 1;
        $data['InvoiceItems'][0]['UnitPrice'] = $arr['total'];
        $data['SourceInfo'] = 'String';

        return $data;
    }

    public static function success($request): string
    {
        DB::beginTransaction();
        try
        {
            $response = self::getFatoorahPaymentStatus($request->paymentId);

            if (isset($response['ValidationErrors'])) return self::myFatoorahErrors($response);

            $res = self::myFatoorahSuccess($request, $response);

            DB::commit();

            return $res;
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function error($request): string
    {
        try
        {
            $response = self::getFatoorahPaymentStatus($request->paymentId);

            if (isset($response['ValidationErrors'])) return self::myFatoorahErrors($response);

            $res = Payment::paymentResponseForMobile(0, 0, 'something error happen', 'error');

            $payment = json_encode($res);

            return "<script type=text/javascript>payment.whenResponseBack('" . $payment . "');</script>";
        }
        catch (Exception $e)
        {
            return ApiResponse::exceptionFails($e);
        }
    }

    public static function setFatoorahInitiatePayment($amount)
    {
        $token = config('pay.payment_key');

        $data = ['InvoiceAmount' => $amount, 'CurrencyIso' => PaymentEnum::CURRENCY];

        return Http::withToken($token)->post(self::base('/v2/InitiatePayment'), $data)->json();
    }

    private static function myFatoorahErrors($response): string
    {
        $res = Payment::paymentResponseForMobile(0, 0, $response['ValidationErrors'], 'error');

        $payment = json_encode($res);

        return "<script type=text/javascript>payment.whenResponseBack('" . $payment . "');</script>";
    }

    private static function myFatoorahSuccess($request, $response): string
    {
        app()->setLocale($request->lang);

        $payment = json_encode(Payment::setPayment($response));

        return "<script type=text/javascript>payment.whenResponseBack('" . $payment . "');</script>";
    }

    private static function getUserDefinedFields($user, $arr): bool|string
    {
        return json_encode([
            'user_id'   => $user->id,
            'course_id' => $arr['course_id'],
            'doctor_id' => $arr['doctor_id'],
            'price'     => $arr['price'],
            'discount'  => $arr['discount'],
            'total'     => $arr['total'],
            'coupon_id' => $arr['coupon_id'],
        ]);
    }

    private static function getFatoorahPaymentStatus($paymentId)
    {
        $url = self::base('/v2/GetPaymentStatus');

        $data = ['keyType' => 'PaymentId', 'key' => $paymentId];

        return Http::withToken(config('pay.payment_key'))->post($url, $data)->json();
    }

    public static function base($url): string
    {
        return Env::get('MY_FATOORAH_BASE_URL', 'https://apitest.myfatoorah.com') . $url;
    }
}
