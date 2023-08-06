<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{ApiResponse, Sms, Uploaded, Warning};
use App\Models\Demand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait DemandApi
{
    public static function apiSetUserJoinRequest($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $code = Sms::code();

            $demand = Demand::firstOrcreate([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'identity'   => $request->identity,
                'address'    => $request->address,
                'code'       => $code,
                'store_name' => $request->store_name,
                'city_id'    => $request->city_id,
                'terms'      => $request->boolean('terms'),
                'logo'       => Uploaded::image($request->logo,'demands'),
            ]);

            DB::commit();

            Sms::send($request->phone, Str::replaceArray('؟', [$code],'كود التفعيل الخاص بك هو : ؟'));

            Demand::sendReviewMail($demand);

            return ApiResponse::success('تم إرسال طلب انضمامك الي الإدارة للمراجعة');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiResendConfirmPhoneCode($request): JsonResponse
    {
        $code = Sms::code();

        DB::table('demands')->where('phone', $request->phone)->update(['code' => $code]);

        Sms::send($request->phone, Str::replaceArray('؟', [$code],'كود التفعيل الخاص بك هو : ؟'));

        return ApiResponse::success();
    }

    public static function apiCheckConfirmCode($request): JsonResponse
    {
        $demand = Demand::wherePhone($request->phone)->first();

        if($request->code !== $demand->code) return Warning::userCodeInvalid();

        DB::table('demands')->where('phone', $request->phone)->update(['code' => null, 'is_active' => true]);

        return ApiResponse::success();
    }

    public static function apiCheckDemandExists($request): JsonResponse
    {
        $demand = Demand::wherePhone($request->phone)->first();

        return ApiResponse::response(['is_exists' => $demand && ($demand->is_accepted !== '0')]);
    }
}
