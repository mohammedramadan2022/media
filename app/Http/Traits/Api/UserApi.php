<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{Api, ApiResponse, Sms, Uploaded, Warning};
use App\Http\Resources\User\UserResource;
use App\Models\{Code, User};
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait UserApi
{
    public static function apiLogin($request): JsonResponse
    {
        if (! $user = User::whereEmail($request->email)->first()) return Warning::userNotFound();

        $check = Code::wherePhone($user->phone)->get(['is_active'])->last();

        if ((! $check || ! $check->is_active) && ! $user->is_active) return Warning::pleaseActiveYourPhoneFirst();

        return Api::login(UserResource::class, $request);
    }

    public static function apiCheckUserActiveCode($request): JsonResponse
    {
        $check = Code::wherePhone($request->phone)->get(['code'])->last();

        if ($check->code != $request->code) return Warning::userCodeInvalid();

        $check->update(['is_active' => 1]);

        $data = array_merge($request->except(['code', 'device_token']), ['app_access_code' => random(8), 'is_active' => 1]);

        return Api::register(User::class, UserResource::class, $data);
    }

    public static function apiRegister($request): JsonResponse
    {
        $code = Sms::code();

        Sms::send($request->phone, self::getMessage($code));

        Code::firstOrcreate(['phone' => $request->phone, 'code' => $code]);

        return ApiResponse::success();
    }

    public static function apiForgetPassword($request): JsonResponse
    {
        return Api::forgetPassword(User::class, $request);
    }

    public static function apiCheckResetCode($request): JsonResponse
    {
        return Api::checkResetCode(User::class, $request);
    }

    public static function apiSetNewPassword($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if (! $user = User::wherePhone($request->phone)->active()->first()) return Warning::userNotFound();

            if (! $user->update(['password' => $request->password])) return Warning::passwordNotChanged();

            DB::commit();

            return ApiResponse::response(UserResource::make($user));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiUpdateUserProfile($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $code = Sms::code();

            $update = array_merge($request->validated(), ['is_active' => 1]);

            $currentModel = $request->user();

            $update['identity'] = $currentModel->identity;

            if ($request->filled('phone') && $currentModel->phone != $request->phone) {
                Code::create(['phone' => $request->phone, 'code' => $code]);

                Sms::send($request->phone, self::getMessage($code));

                $update = ['is_active' => 0, 'code' => $code] + $request->except('phone');
            }

            if ($request->hasFile('identity') && ! is_null($request->identity)) {
                storage_unlink('identities', $currentModel->identity);

                $update['identity'] = Uploaded::image($request->identity,'identity');
            }

            $currentModel->update($update);

            DB::commit();

            return ApiResponse::response(UserResource::make($currentModel));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiChangePassword($request): JsonResponse
    {
        return Api::changePassword($request);
    }

    public static function apiGetUpdatedProfile($request): JsonResponse
    {
        return ApiResponse::response(UserResource::make(auth()->guard('api')->user()));
    }

    public static function apiCheckUserPhoneActive($request): JsonResponse
    {
        $check = Code::wherePhone($request->phone)->get()->last();

        if ($check->code != $request->code) return Warning::userCodeInvalid();

        $check->update(['is_active' => 1]);

        $request->user()->update(['phone' => $request->phone, 'is_active' => 1]);

        return ApiResponse::response(UserResource::make($request->user()));
    }

    public static function apiResendActivePhoneCode($request): JsonResponse
    {
        $code = Sms::code();

        Code::create(['phone' => $request->phone, 'code' => $code]);

        Sms::send($request->phone, self::getMessage($code));

        return ApiResponse::success();
    }

    private static function getMessage($code): string
    {
        return 'كود التفعيل الخاص بك هو : ' . $code;
    }
}
