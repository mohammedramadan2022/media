<?php

namespace App\Http\Middleware;

use App\Facade\Support\Core\ApiResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        Carbon::setLocale($request->header('lang'));

        $auth = (object)auth()->guard($guard);

        if ($auth->check()) {
            if (! $auth->user()->status) {
                Auth::guard($guard)->logout();

                return self::setRoutesRedirect($request, trans('api.user-status-is-not-active'));
            }

            if ($auth->user()->is_blocked) {
                Auth::guard($guard)->logout();

                $message = trans('api.this-account-is-blocked', ['number' => getSetting('contact_mobile_phone')]);

                return self::setRoutesRedirect($request, $message);
            }
        }

        return $next($request);
    }

    private static function setRoutesRedirect($request, $message)
    {
        if (self::checkUrl($request, 'api')) {
            return ApiResponse::warning($message);
        } elseif (self::checkUrl($request, 'provider-panel')) {
            return self::setRedirect('provider.login', $message);
        } elseif (self::checkUrl($request, 'admin-panel')) {
            return self::setRedirect('admin.login', $message);
        } else {
            return redirect('/')->with('danger', $message);
        }
    }

    private static function checkUrl($request, $needles): bool
    {
        return str()->contains($request->url(), $needles);
    }

    private static function setRedirect($route, $message): RedirectResponse
    {
        return redirect()->route($route)->with('danger', $message);
    }
}
