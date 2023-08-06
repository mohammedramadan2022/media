<?php

namespace App\Http\Traits;

use App\Enums\PaymentEnum;
use App\Http\Scopes\PaymentScopes;
use App\Http\Traits\Api\PaymentApi;
use App\Models\Order;
use App\Models\Payment;
use App\Http\Traits\pay\{DelayPayment, WalletPayment, InsurancePayment, OnlinePayment, PaymentHelper};

trait PaymentTrait
{
    use BasicTrait, PaymentScopes, OnlinePayment, WalletPayment, DelayPayment, InsurancePayment, PaymentHelper, PaymentApi;

    public static function payOrderDelay($order, $transaction_id)
    {
        return Payment::create([
            'user_id'          => $order->user_id,
            'amount'           => $order->delay_penalty,
            'currency'         => PaymentEnum::CURRENCY,
            'transaction_id'   => $transaction_id,
            'paymentable_type' => Order::class,
            'paymentable_id'   => $order->id,
            'username'         => $order->user->full_name,
        ]);
    }
}
