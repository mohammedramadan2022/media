<?php

namespace App\Http\Middleware;

use App\Facade\Support\Core\Warning;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        Carbon::setLocale($request->header('lang'));

        if (! $request->user()->status) {
            Auth::guard('api')->logout();

            return Warning::userStatusIsNotActive();
        }

        return $next($request);
    }
}
