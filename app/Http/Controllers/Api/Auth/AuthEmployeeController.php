<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facade\Support\Core\Api;
use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\Employee\{AdminLoginRequest, EmployeeSearchRequest, SetEmployeeWorkStatusRequest, UpdateAdminProfileRequest};
use App\Http\Requests\Api\User\{ChangePasswordRequest, CheckResetCodeRequest, CheckUserNewPhoneCodeRequest, ForgetPasswordRequest};
use App\Http\Requests\Api\User\{ResendUserPhoneCodeRequest, SetNewPasswordRequest};
use App\Models\Admin;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthEmployeeController extends PARENT_API
{
    public function login(AdminLoginRequest $request): JsonResponse
    {
        return Admin::apiLogin($request);
    }

    public function updateEmployeeProfile(UpdateAdminProfileRequest $request): JsonResponse
    {
        return Admin::apiUpdateAdminProfile($request);
    }

    public function getUpdatedProfile(): JsonResponse
    {
        return Admin::apiGetUpdatedProfile();
    }

    public function checkEmployeePhoneActive(CheckUserNewPhoneCodeRequest $request): JsonResponse
    {
        return Admin::apiCheckAdminPhoneActive($request);
    }

    public function resendActivePhoneCode(ResendUserPhoneCodeRequest $request): JsonResponse
    {
        return Admin::apiResendActivePhoneCode($request);
    }

    public function changeAdminPassword(ChangePasswordRequest $request): JsonResponse
    {
        return Admin::apiChangePassword($request);
    }

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        return Admin::apiForgetPassword($request);
    }

    public function checkResetCode(CheckResetCodeRequest $request): JsonResponse
    {
        return Admin::apiCheckResetCode($request);
    }

    public function resetPassword(SetNewPasswordRequest $request): JsonResponse
    {
        return Admin::apiSetNewPassword($request);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return Admin::apiChangePassword($request);
    }

    public function getNotificationsPage(Request $request): JsonResponse
    {
        return Notification::apiGetAuthNotifications($request);
    }

    public function setEmployeeWorkStatus(SetEmployeeWorkStatusRequest $request): JsonResponse
    {
        return Admin::apiSetEmployeeWorkStatus($request);
    }

    public function search(EmployeeSearchRequest $request): JsonResponse
    {
        return Order::apiSearch($request);
    }

    public function logout(): JsonResponse
    {
        return Api::logout('admin_api');
    }
}
