<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{Api, ApiResponse, Sms, Uploaded, Warning};
use App\Http\Resources\Employee\AdminResource;
use App\Models\Admin;
use App\Models\Code;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait AdminApi
{
    public static function apiLogin($request): JsonResponse
    {
        $check = Admin::active()->where('email', $request->email)->where('role_id', $request->role_id)->first();

        if (! $check) return ApiResponse::authFail();

        return Api::login(AdminResource::class, $request, 'admin_api');
    }

    public static function apiForgetPassword($request): JsonResponse
    {
        return Api::forgetPassword(Admin::class, $request);
    }

    public static function apiCheckResetCode($request): JsonResponse
    {
        return Api::checkResetCode(Admin::class, $request);
    }

    public static function apiSetNewPassword($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if (! $admin = Admin::wherePhone($request->phone)->active()->first()) return Warning::adminIsNotFound();

            if (! $admin->update(['password' => $request->password])) return Warning::passwordNotChanged();

            DB::commit();

            return ApiResponse::response(AdminResource::make($admin));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiUpdateAdminProfile($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $currentModel = $request->user();

            $code = Sms::code();

            $update = ['is_active' => 1] + $request->validated();

            if ($request->filled('phone') && $currentModel->phone != $request->phone) {
                Code::create(['phone' => $request->phone, 'code' => $code]);

                Sms::send($request->phone, self::getMessage($code));

                $update = ['is_active' => 0, 'code' => $code] + $request->except('phone');
            }

            if ($request->filled('image')) {
                storage_unlink('admins', $currentModel->image?->image);

                $currentModel->image()->update(['image' => Uploaded::image($request->image, 'admin')]);
            }

            $currentModel->update($update);

            DB::commit();

            return ApiResponse::response(AdminResource::make($currentModel));
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

    public static function apiGetUpdatedProfile(): JsonResponse
    {
        return ApiResponse::response(AdminResource::make(auth()->guard('admin_api')->user()));
    }

    public static function apiCheckAdminPhoneActive($request): JsonResponse
    {
        $check = Code::wherePhone($request->phone)->latest()->first();

        if ($check->code != $request->code) {
            return Warning::userCodeInvalid();
        }

        $check->update(['is_active' => 1]);

        $request->user()->update(['phone' => $request->phone, 'is_active' => 1, 'code' => null]);

        return ApiResponse::response(AdminResource::make($request->user()));
    }

    public static function apiResendActivePhoneCode($request): JsonResponse
    {
        $code = Sms::code();

        Code::create(['phone' => $request->phone, 'code' => $code]);

        Sms::send($request->phone, self::getMessage($code));

        return ApiResponse::success();
    }

    public static function apiSetEmployeeWorkStatus($request): JsonResponse
    {
        $value = $request->status == 'active';

        DB::table('admin_statuses')
            ->where('admin_id', $request->user()->id)
            ->update(['current_status' => $value]);

        return ApiResponse::success();
    }

    private static function getMessage($code): string
    {
        return 'كود التحقق الخاص بك هو : ' . $code;
    }
}
