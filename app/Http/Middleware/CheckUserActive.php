<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    public function handle($request, Closure $next)
    {
        if (! $request->user()->status) {
            Auth::guard('web')->logout();

            return redirect('/login')->with('accountLocked', 'عفوا تم ايقاف تفعيل هذا الحساب من قبل الادارة يرجي التواصل لحل المشكلة');
        }

        return $next($request);
    }
}
