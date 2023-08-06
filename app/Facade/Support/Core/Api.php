<?php

namespace App\Facade\Support\Core;

use App\Facade\Support\Tools\MobilePhone;
use App\Http\Resources\User\UserResource;
use App\Models\Code;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Api
{
    public static function login($resource, $request, $guard = 'api', $onlyAuth = false): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $token = auth()->guard($guard)->attempt(self::credentials($request));

            if (! $token) return ApiResponse::authFail();

            $auth = (object) auth()->guard($guard)->user();

            if ($auth->is_blocked) return Warning::thisAccountIsBlocked();

            if (! $auth->status) return Warning::userStatusIsNotActive();

            self::setNewTokenAndFcm($request, $auth, $token);

            // this line in case of using multi users
            $auth->token()->where('uuid', $request->header('uuid'))->update(['jwt' => $token]);

            DB::commit();

            return $onlyAuth ? $auth : ApiResponse::response($resource::make($auth));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function register($model, $resource, $request, $withCreated = false, $other = [])
    {
        $data = ! is_array($request) ? $request->validated() + $other : $request;

        DB::beginTransaction();
        try
        {
            $created = $model::create(except($data, ['image']));

            if (isset($request['image'])) Uploaded::uploadAndCreate($created,'image', getModelName($model));

            DB::commit();

            return $withCreated ? $created : ApiResponse::response($resource::make($created));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function checkModelPhoneExists($model, $request): JsonResponse
    {
        try
        {
            if ($model::wherePhoneAndCountryCode($request->phone, $request->country_code)->first()) return Warning::phoneAlreadyExists();

            $code = Sms::code();

            Code::firstOrcreate(['phone' => $request->phone, 'country_code' => $request->country_code, 'code' => $code]);

            $mobile_phone = MobilePhone::setPrefix($request->phone);

            Sms::send($mobile_phone, 'كود التفعيل هو : '.$code);

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            return ApiResponse::exceptionFails($e);
        }
    }

    public static function checkModelActiveCode($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $codes = Code::wherePhone($request->phone)->get();

            $check = $codes->last();

            if (! $check) return Warning::userNotFound();

            if ($check->code != $request->code) return Warning::userCodeInvalid();

            $check->update(['is_active' => 1]);

            DB::commit();

            return ApiResponse::successTrans('activation-done-successfully');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function forgetPassword($model, $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if (! $user = $model::wherePhone($request->phone)->first()) return Warning::userNotFound();

            $code = Sms::code();

            $user->update(['code' => $code]);

            $message = 'كود إعادة تعيين كلمة المرور هو : '.$code;

            Sms::send(getFormattedPhone($user->phone), $message);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function changePassword($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $user = $request->user();

            if (! $user) return Warning::userIsNotFoundOrNotActived();

            if (! Hash::check($request['old_password'], $user->password)) return Warning::passwordIsNotMatched();

            $user->update(['password' => $request['new_password']]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function checkResetCode($model, $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if (! $user = $model::wherePhone($request->phone)->whereCode($request->code)->first()) return Warning::userCodeInvalid();

            $user->update(['code' => null]);

            DB::commit();

            return ApiResponse::successTrans('user-code-valid');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function setNewPassword($model, $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if (! $user = $model::wherePhone($request->phone)->active()->first()) return Warning::userNotFound();

            if (! $user->update(['password' => $request->password])) return Warning::passwordNotChanged();

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function updateModelProfile($request, $guard = 'api', $resource = null): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $user = $request->user();

            $userResource = $resource;

            $folder = plural($guard);

            if ($guard == 'api') {
                $folder = 'users';

                $userResource = UserResource::class;
            }

            if ($request->has('image')) Uploaded::updateAndDelete($user,'image', $folder);

            $user->update($request->validated());

            if (! $userResource) return ApiResponse::success();

            DB::commit();

            return ApiResponse::response($userResource::make($user));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function activeModelPhoneOrEmail($request, $resource, $guard = 'api'): JsonResponse
    {
        $auth = $request->user();

        if ($auth->code != $request->code) return Warning::userCodeInvalid();

        if (! $check = Code::wherePhone($request->phone)->where('is_active',0)->get()->last()) {
            return Warning::userCodeInvalid();
        }

        if ($check->phone != $request->phone) return Warning::invalidPhoneNumber();

        $auth->update(['code' => null, 'phone' => $request->phone, 'is_active' => 1]);

        $check->update(['is_active' => 1]);

        return ApiResponse::response($resource::make($auth));
    }

    public static function logout($guard): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $auth = auth()->guard($guard);

            $user = (object) $auth->user();

            $model = getClass(request()->user()->getTable());

            if (config('fcm.user_have_multi_devices_in_same_account')) {
                DB::table('tokens')
                    ->where('tokenable_type', $model)
                    ->where('tokenable_id', request()->user()->id)
                    ->where('uuid', request()->header('uuid') ?? 'uuid')
                    ->update(['jwt' => null]);

                DB::table('fcms')
                    ->where('fcmable_type', $model)
                    ->where('fcmable_id', request()->user()->id)
                    ->where('fcm', request('device_token'))
                    ->delete();
            } else {
                $user->token->update(['jwt' => null]);

                $user->fcm->update(['fcm' => null]);

                $auth->logout();
            }

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function deactivateAccount(): JsonResponse
    {
        request()->user()->update(['deleted_at' => now()]);

        return ApiResponse::success();
    }

    private static function credentials($request): array
    {
        return array_merge(self::username($request), ['password' => $request->password]);
    }

    private static function username($request): array
    {
        $type = is_numeric($request->email) ? 'phone' : 'email';

        return [$type => $request->get($type)];
    }

    private static function setNewTokenAndFcm($request, $auth, $token): void
    {
        if ($request->filled('device_token')) {
            $type = $request->hasHeader('website') ? 'web' : 'mobile';

            $auth->fcm()->create(['fcm' => $request->device_token, 'type' => $type]);
        }

        $auth->token()->create(['jwt' => $token, 'uuid' => $request->header('uuid'), 'ip' => $request->ip()]);
    }
}
