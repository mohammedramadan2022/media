<?php

namespace App\Exceptions;

use App\Facade\Support\Core\ApiResponse;
use Error;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|RedirectResponse|Response
    {
        if (contains($request->url(),'api'))
        {
            $res = parent::render($request, $e);
            if ($e instanceof TokenInvalidException) return ApiResponse::unAuth('Token invalid');
            elseif ($e instanceof NotFoundHttpException) return self::setHandlerResponse(e: $e, message: 'Not Found', code: Response::HTTP_NOT_FOUND);
            elseif ($e instanceof ErrorException) return self::setHandlerResponse(e: $e, data: null);
            elseif ($e instanceof Error) return self::setHandlerResponse(e: $e, data: null);
            elseif ($e instanceof ThrottleRequestsException) return self::setHandlerResponse(e: $e, message: 'Too Many Attempts.', code: Response::HTTP_TOO_MANY_REQUESTS);
            elseif ($e instanceof ModelNotFoundException) return self::setHandlerResponse(e: $e, message: 'Model Not Found.', code: Response::HTTP_NOT_FOUND);
            else return self::setHandlerResponse(e:$e, code: $res->status());
        }

        $res = parent::render($request, $e);

        if ($res->status() === 419) return back()->with(['danger' => trans('back.page-expired')]);

        if ($e instanceof NotFoundHttpException && !$request->ajax())
        {
            if (contains($request->path(), 'admin-panel')) return Route::respondWithRoute('admin.not-found');

            elseif (contains($request->path(), 'provider-panel')) return Route::respondWithRoute('provider.not-found');
        }

        return $res;
    }

    public function unauthenticated($request, AuthenticationException $exception): Response|RedirectResponse
    {
        $login = match (Arr::get($exception->guards(),0)) {
            'admin'    => 'admin.login',
            'provider' => 'provider.login',
            default    => 'login',
        };

        return redirect()->guest(route($login));
    }

    private static function setHandlerResponse($e, $data = [], $message = '', $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $error = $message == '' ? getFormattedException($e) : '';

        return response()->json(['data' => $data, 'status' => false, 'message' => $message, 'error' => $error], $code);
    }
}
