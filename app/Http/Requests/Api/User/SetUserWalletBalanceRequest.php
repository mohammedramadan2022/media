<?php

namespace App\Http\Requests\Api\User;

class SetUserWalletBalanceRequest
{
    public function rules(): array
    {
        return [
            'balance' => ['required', 'numeric', 'min:1'],
        ];
    }
}
