<?php

namespace App\Facade\Support\Pay;

use App\Enums\PaymentEnum;
use App\Repository\Contracts\PayInterface;
use Illuminate\Support\Facades\Http;

class Moyasar implements PayInterface
{
    public const SUCCESS = 'paid'; // change it to "paid" cause it works in production only if it is success

    public const FAILED = 'failed';

    public static function charge($arr): array
    {
        $response = Http::post(self::baseUrl(), self::getMoyasarChargeData($arr))->object();

        if (in_array($response->type ?? '', self::handleError())) {
            return ['payment_url' => '', 'message' => $response->message, 'error' => $response->errors];
        }

        return ['payment_url' => $response->source->transaction_url, 'message' => 'success', 'error' => ''];
    }

    public static function fetch($id): \Moyasar\Payment
    {
        return \Moyasar\Facades\Payment::fetch($id);
    }

    private static function getMoyasarChargeData($arr): array
    {
        $callback_url = $arr['callback_url'] ?? root() . '/api/payments/success?lang=ar';

        return [
            'publishable_api_key' => config('pay.moyasar.publishable_key'),
            'amount'              => $arr['amount'],
            'currency'            => PaymentEnum::CURRENCY,
            'description'         => $arr['description'],
            'callback_url'        => $callback_url,
            'source'              => self::getCreditCardSource($arr),
            'metadata'            => $arr['metadata'] ?? [], // this is optional object that can send anything you want :)
        ];
    }

    private static function baseUrl(): string
    {
        return config('pay.moyasar.url');
    }

    private static function getCreditCardSource($arr): array
    {
        return [
            'type'      => 'creditcard',
            'name'      => $arr['name'],
            'number'    => $arr['number'],
            'cvc'       => $arr['cvc'],
            'month'     => $arr['month'],
            'year'      => $arr['year'],
            'manual'    => false,
            'save_card' => false,
        ];
    }

    private static function handleError(): array
    {
        return [
            'invalid_request_error',
            'authentication_error',
            'api_connection_error',
            'account_inactive_error',
            '3ds_auth_error',
            'api_error',
            'rate_limit_error',
        ];
    }
}
