<?php

namespace App\Http\Traits\Other;

trait WalletHelper
{
    private static function setTransactionData($request): array
    {
        return [
            'trainer_id' => $request->user()->id,
            'amount'     => $request->user()->wallet,
            'name'       => $request->name,
            'account_no' => $request->account_no,
            'iban'       => $request->iban,
            'bank_name'  => $request->bank_name,
        ];
    }

    private static function setWalletData($request, $type): array
    {
        return [
            'trainer_id'   => $request->user()->id,
            'balance'      => $request->user()->wallet,
            'process_type' => $type,
            'process_no'   => create_rand_numbers(5),
        ];
    }
}
