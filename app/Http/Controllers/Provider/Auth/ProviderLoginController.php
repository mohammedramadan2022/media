<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Facade\Support\Tools\CrudMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProviderLoginRequest;
use App\Http\Traits\Other\AuthLoginTrait;
use App\Mail\SendProviderResetMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log, Mail};
use Illuminate\View\View;

class ProviderLoginController extends Controller
{
    use AuthLoginTrait;

    public function __construct()
    {
        $this->middleware('guest:provider')->except('providerLogout');
    }

    public function showProviderLoginForm(): View
    {
        return view('auth.pages.provider.providerLogin');
    }

    public function providerLogin(ProviderLoginRequest $request): RedirectResponse
    {
        $inputs = self::getRedirectInput($request);

        $guard = auth()->guard('provider');

        if (! $guard->attempt(self::getCredentials($request), $request->remember)) {
            return CrudMessage::warningWithInput(trans('back.invalid-account-info'), $inputs);
        }

        if (! $guard->user()) {
            return redirect()->route('provider.login')->with('danger', 'Please Try Again');
        }

        if (((object) $guard->user())->status == 0) {
            $guard->logout();

            return CrudMessage::warningWithInput(trans('back.account-has-been-disactive'), $inputs);
        }

        return redirect()->intended(url('/provider-panel'));
    }

    public function forgetPassword(): View
    {
        return view('auth.pages.provider.providerForgetPassword');
    }

    public function confirmedResetMail(): View
    {
        return view('auth.pages.provider.providerConfirmedMail');
    }

    public function sendResetMail(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = random(60);

        DB::table('password_resets')->insert(self::passwordResetData($request->email, $token));

        Mail::to($request->email)->send(new SendProviderResetMail($token, 'نسيت كلمة المرور'));

        Log::info(url('/provider-panel/provider-reset-password/'.$token));

        return redirect()->route('provider.confirmedResetMail')->with('email', $request->email);
    }

    public function providerResetPassword($token): View
    {
        return view('auth.pages.provider.providerResetForm', compact('token'));
    }

    public function providerChangePassword(Request $request): RedirectResponse
    {
        $request->validate(self::getValidationRules());

        $check = DB::table('password_resets')->where('token', $request->token)->latest()->first();

        if (! $check) return redirect()->route('provider.login')->with('danger', 'Invalid Token');

        $provider = User::whereEmail($check->email)->first();

        if (! $provider) {
            return redirect()->route('provider.login')->with('danger', 'من فضلك حاول مرة أخري');
        }

        $provider->update(['password' => $request->new_password]);

        DB::table('password_resets')->where('email', $provider->email)->delete();

        return redirect()->route('provider.login')->with('success', trans('api.password-changed-successfully'));
    }

    public function providerLogout(): RedirectResponse
    {
        Auth::guard('provider')->logout();

        return redirect()->route('provider-panel');
    }
}
