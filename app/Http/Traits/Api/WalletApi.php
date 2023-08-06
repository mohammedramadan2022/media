<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{ApiResponse, Pay, Warning};
use App\Http\Resources\User\WalletResource;
use App\Models\Payment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait WalletApi
{
    public static function apiGetUserWallet($request): JsonResponse
    {
        return ApiResponse::response([
            'balance'      => (int)$request->user()->wallet,
            'currency'     => trans('back.reyal'),
            'transactions' => WalletResource::collection($request->user()->wallets->sortDesc()),
        ]);
    }

    public static function apiChargeWallet($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $data = Payment::setPayCardHolder($request->amount,'Charge client wallet', $request);

            $data['metadata']['user_id'] = $request->user()->id;
            $data['metadata']['amount'] = $request->amount;

            $data['callback_url'] = Pay::setCallbackUrl('wallet');

            $pay = Pay::charge($data);

            if ($pay->payment_url == '') return Warning::sorryPaymentProcessFailed();

            DB::commit();

            return ApiResponse::response(['payment_url' => $pay->payment_url]);
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }
}
