<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminStatus
{
    public function handle($request, Closure $next)
    {
        if (! $request->user()->status) {
            Auth::guard('admin')->logout();

            return redirect('/admin-panel/login')->with('accountLocked', 'عفوا تم إيقاف تفعيل هذا الحساب من قبل الإدارة يرجي التواصل لحل المشكلة');
        }

        return $next($request);
    }
}
