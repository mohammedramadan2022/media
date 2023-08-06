<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facade\Support\Core\Api;
use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\{ChangePasswordRequest, CheckResetCodeRequest, CheckUserActiveCodeRequest, CheckUserNewPhoneCodeRequest};
use App\Http\Requests\Api\User\{RegisterRequest, ResendUserPhoneCodeRequest, SetNewPasswordRequest, UpdateUserProfileRequest};
use App\Http\Requests\Api\User\{UserLoginRequest, ForgetPasswordRequest};
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends PARENT_API
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        return User::apiLogin($request);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return User::apiRegister($request);
    }

    public function checkUserActiveCode(CheckUserActiveCodeRequest $request): JsonResponse
    {
        return User::apiCheckUserActiveCode($request);
    }

    public function updateUserProfile(UpdateUserProfileRequest $request): JsonResponse
    {
        return User::apiUpdateUserProfile($request);
    }

    public function getUpdatedProfile(Request $request): JsonResponse
    {
        return User::apiGetUpdatedProfile($request);
    }

    public function checkUserPhoneActive(CheckUserNewPhoneCodeRequest $request): JsonResponse
    {
        return User::apiCheckUserPhoneActive($request);
    }

    public function resendActivePhoneCode(ResendUserPhoneCodeRequest $request): JsonResponse
    {
        return User::apiResendActivePhoneCode($request);
    }

    public function changeUserPassword(ChangePasswordRequest $request): JsonResponse
    {
        return User::apiChangePassword($request);
    }

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        return User::apiForgetPassword($request);
    }

    public function checkResetCode(CheckResetCodeRequest $request): JsonResponse
    {
        return User::apiCheckResetCode($request);
    }

    public function resetPassword(SetNewPasswordRequest $request): JsonResponse
    {
        return User::apiSetNewPassword($request);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return User::apiChangePassword($request);
    }

    public function logout(): JsonResponse
    {
        return Api::logout('api');
    }

    public function deactivateUserAccount(): JsonResponse
    {
        return Api::deactivateAccount();
    }
}
