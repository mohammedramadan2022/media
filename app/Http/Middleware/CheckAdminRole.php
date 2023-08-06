<?php

namespace App\Http\Middleware;

use App\Facade\Support\Tools\CrudMessage;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle($request, Closure $next)
    {
        $auth = auth()->guard('admin')->user();

        if ($request->ajax() && ! permission_checker($auth)) {
            return CrudMessage::warning(trans('back.has-no-permission'),Response::HTTP_FORBIDDEN);
        }

        if (! permission_checker($auth)) abort(Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
