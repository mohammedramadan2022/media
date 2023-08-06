<?php

namespace App\Http\Controllers\Back\Auth;

use App\Facade\Support\Tools\CrudMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Traits\Other\AuthLoginTrait;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    use AuthLoginTrait;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.pages.admin.adminLogin');
    }

    public function adminLogin(AdminLoginRequest $request)
    {
        if (! Auth::guard('admin')->attempt($request->only(['email', 'password']), $request->remember)) {
            return CrudMessage::warningWithInput(trans('back.invalid-account-info'), $request->only('email'));
        }

        if (admin()->status == 0) {
            auth()->guard('admin')->logout();

            return CrudMessage::warningWithInput(trans('back.account-has-been-disactive'), $request->only('email'));
        }

        session()->regenerate();

        return redirect()->intended('/admin-panel');
    }

    public function forgetPassword()
    {
        return view('auth.pages.admin.adminForgetPassword');
    }

    public function confirmedResetMail()
    {
        return view('auth.pages.admin.adminConfirmedMail');
    }

    public function sendResetMail(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'exists:admins,email']]);

        $token = random(60);

        DB::table('password_resets')->insert(self::passwordResetData($request->email, $token));

        //SendEmail::dispatch($request->email, new SendResettingMail($token));

        return redirect()->route('admin.confirmedResetMail')->with('email', $request->email);
    }

    public function adminResetPassword($token)
    {
        return view('auth.pages.admin.adminResetForm', compact('token'));
    }

    public function adminChangePassword(Request $request)
    {
        $request->validate(self::getValidationRules());

        $check = DB::table('password_resets')->where('token', $request->token)->latest()->first();

        if (! $check) return redirect()->route('admin.login')->with('danger', 'Invalid Token');

        $admin = Admin::whereEmail($check->email)->first();

        if (! $admin) return redirect()->route('admin.login')->with('danger', 'من فضلك حاول مرة أخري');

        $admin->update(['password' => $request->new_password]);

        DB::table('password_resets')->where('email', $admin->email)->delete();

        return redirect()->route('admin.login')->with('success', trans('api.password-changed-successfully'));
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();

        Session::flush();

        return redirect()->route('admin-panel');
    }
}
