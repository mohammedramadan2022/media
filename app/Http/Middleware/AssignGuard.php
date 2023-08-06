<?php

namespace App\Http\Middleware;

use App\Facade\Support\Core\ApiResponse;
use App\Models\{Admin, Token, User};
use Closure;
use Illuminate\Http\Request;

class AssignGuard
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard != null) auth()->shouldUse($guard);

        if (auth()->guard($guard)->check()) {
            [$jwt] = explode('Bearer ', $request->bearerToken());

            $type = $guard == 'api' ? User::class : Admin::class;

            $currentJwt = Token::whereJwtAndTokenableType($jwt, $type)->first();

            if (! $currentJwt) {
                auth()->guard($guard)->logout();

                return ApiResponse::unAuth();
            }

            return $next($request);
        }

        return ApiResponse::unAuth();
    }
}
