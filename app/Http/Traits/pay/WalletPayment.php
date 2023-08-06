<?php

namespace App\Http\Traits\pay;

use App\Enums\WalletEnum;
use App\Facade\Support\Pay\Moyasar;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

trait WalletPayment
{
    public static function walletSuccess($request): string
    {
        app()->setLocale($request->lang);

        $payment = json_encode(self::setWalletPayment($request));

        return "<script type=text/javascript>payment.whenResponseBack('".$payment."');</script>";
    }

    public static function walletWebSuccess($request): RedirectResponse
    {
        if ($request->status == Moyasar::FAILED) {
            return redirect()->to('/profile/wallet?status='.Moyasar::FAILED.'&message='.$request->message);
        }

        $res = self::saveWalletAmount($request);

        if ($res['status'] && empty($res['error'])) {
            return redirect()->to('/profile/wallet?status='.Moyasar::SUCCESS.'&message='.$res['message']);
        }

        return redirect()->to('/profile/wallet?status='.Moyasar::FAILED.'&message='.$res['error']);
    }

    private static function saveWalletAmount($request): array
    {
        DB::beginTransaction();
        try
        {
            $response = Moyasar::fetch($request->id);

            $meta = (object) $response->metadata;

            if ($request->status == Moyasar::SUCCESS) {
                $user = User::find($meta->user_id);

                $user->update(['wallet' => $user->wallet + $meta->amount]);

                $user->wallets()->create(['type' => WalletEnum::SHIPPED, 'amount' => $meta->amount]);

                DB::commit();
            }

            return ['status' => true, 'error' => '', 'message' => trans(key: 'api.request-done-successfully', locale: $request->lang)];
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ['statue' => false, 'error' => $e, 'message' => 'error'];
        }
    }

    public static function setWalletPayment($request): array
    {
        DB::beginTransaction();
        try
        {
            self::saveWalletAmount($request);

            DB::commit();

            return self::paymentSuccessResponseForMobile();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return self::paymentErrorResponseForMobile(getFormattedException($e));
        }
    }
}
