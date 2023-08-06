<?php

namespace App\Facade\Support\Tools;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Ajax
{
    public static function response($data = [], $status = true, $message = '', $code = Response::HTTP_OK): JsonResponse
    {
        $message = ($message == '') ? trans('api.request-done-successfully') : $message;

        return response()->json(['data' => $data, 'status' => $status, 'message' => $message], $code);
    }

    public static function success(): JsonResponse
    {
        return self::response();
    }

    public static function fails($message): JsonResponse
    {
        return self::response([],false, $message);
    }
}
