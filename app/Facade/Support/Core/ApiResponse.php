<?php

namespace App\Facade\Support\Core;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function response($data = null, $type = 'success', $pagination = null, $msg = '', $code = Response::HTTP_OK, $err = ''): JsonResponse
    {
        $response = ['data' => $data, 'status' => true, 'message' => $msg, 'error' => $err];

        if ($type == 'success') {
            if ($pagination && isset($pagination->total)) {
                $res['data'] = $data;
                $res['pagination']['total'] = $pagination->total;
                $res['pagination']['last_page'] = $pagination->last_page;
                $res['pagination']['perPage'] = $pagination->perPage;
                $res['pagination']['currentPage'] = $pagination->currentPage;
            } else {
                $res = $data;
            }

            $response['data'] = $res;

            $response['message'] = ($msg == '') ? trans('api.request-done-successfully') : $msg;
        }

        if (in_array($type, ['warning', 'fails', 'unAuth'])) {
            $response['status'] = false;
        }

        return response()->json($response, $code);
    }

    public static function warning($message = '', $data = null): JsonResponse
    {
        return self::response(data: $data, type: 'warning', msg: $message, code: Response::HTTP_BAD_REQUEST);
    }

    public static function warningTrans($key, $data = null): JsonResponse
    {
        return self::warning(trans('api.'.$key), $data);
    }

    public static function validation($message, $data = null): JsonResponse
    {
        return self::response(data: $data, type: 'warning', msg: $message, code: Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function validationTrans($key, $data = null): JsonResponse
    {
        return self::response(data: $data, type: 'warning', msg: trans('api.'.$key), code: Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function success($message = '', $data = null): JsonResponse
    {
        return self::response(data: $data, msg: $message);
    }

    public static function successTrans($key, $data = null): JsonResponse
    {
        return self::success(trans('api.'.$key), $data);
    }

    public static function unAuth($message = 'Unauthenticated', $code = Response::HTTP_UNAUTHORIZED, $data = null): JsonResponse
    {
        return self::response(data: $data, type: 'fails', msg: $message, code: $code);
    }

    public static function authFail($code = Response::HTTP_BAD_REQUEST, $data = null): JsonResponse
    {
        return self::response(data: $data, type: 'unAuth', msg: trans('auth.failed'), code: $code);
    }

    public static function fails($error = '', $data = null): JsonResponse
    {
        $errorMessage = ($error == '') ? trans('api.server-internal-error') : getFormattedException($error);

        return self::response(data: $data, type: 'fails', code: Response::HTTP_INTERNAL_SERVER_ERROR, err: $errorMessage);
    }

    public static function exceptionFails($e, $data = null): JsonResponse
    {
        $message = is_string($e) ? $e : getFormattedException($e);

        if (contains($message, 'cURL error 6')) {
            return self::response_fails($data, 'No Internet Connection');
        }

        return self::response_fails($data, $message);
    }

    public static function pagination($collection, $resource): JsonResponse
    {
        $pagination = self::paginated($collection);

        $data = $resource::collection($pagination->paginated);

        return self::response($data,'success', $pagination);
    }

    public static function dynamicPages($name, $other = []): JsonResponse
    {
        $setting = getSetting($name.'_'.app()->getLocale()) ?? '';

        if (empty($other)) {
            return self::response($setting);
        }

        return self::response($other + [$name => $setting]);
    }

    public static function notFound($name): JsonResponse
    {
        return self::warning(trans('api.'.$name.'-is-not-found'));
    }

    public static function notActive($name): JsonResponse
    {
        return self::warning(trans('api.'.$name.'-is-not-active'));
    }

    private static function paginated($collection): object
    {
        $data['total'] = $collection->total();
        $data['paginated'] = $collection;
        $data['currentPage'] = $collection->currentPage();
        $data['perPage'] = 10;
        $data['last_page'] = $collection->lastPage();

        return (object) $data;
    }

    private static function response_fails($data, $err): JsonResponse
    {
        return self::response(data: $data, type: 'fails', code: Response::HTTP_INTERNAL_SERVER_ERROR, err: $err);
    }
}
