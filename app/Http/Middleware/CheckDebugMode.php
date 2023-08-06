<?php

namespace App\Http\Middleware;

use App\Facade\Support\Tools\Environment;
use Closure;
use Illuminate\Http\Request;

class CheckDebugMode
{
    public function handle(Request $request, Closure $next)
    {
        Environment::updateBool('APP_DEBUG', getBoolSetting('app_debug'));

        return $next($request);
    }
}
