<?php

namespace App\Facade\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait CrudResponseTrait
{
    public static function crudResponse($mess, $requestStatus = true, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['requestStatus' => $requestStatus, 'message' => $mess], $code);
    }

    public static function warning($mess, $code = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return self::crudResponse($mess,false, $code);
    }

    public static function warningTrans($mess, $code = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return self::warning(trans($mess), $code);
    }

    public static function fails($e = ''): JsonResponse
    {
        $res = self::setExceptionMessage($e);

        return self::crudResponse(mess: $res->mess, requestStatus: false, code: $res->code);
    }

    public static function deleteResponse($mess): JsonResponse
    {
        return self::crudDeleteResponse(error: '', mess: $mess);
    }

    public static function successResponse($message = ''): JsonResponse
    {
        return self::crudResponse($message == '' ? trans('api.request-done-successfully') : $message);
    }

    public static function edit($obj): JsonResponse
    {
        return self::crudResponse(translated('edit', plural_parts($obj)));
    }

    public static function add(string $obj): JsonResponse
    {
        return self::crudResponse(translated('add', plural_parts($obj)));
    }

    public static function delete($obj): JsonResponse
    {
        return self::crudResponse(translated('delete', plural_parts($obj)));
    }

    public static function deleteResponseFails($e = ''): JsonResponse
    {
        return self::crudDeleteResponse(error: self::setExceptionMessage($e)->mess, deleteStatus: false);
    }

    private static function crudDeleteResponse($error, $mess = '', $deleteStatus = true): JsonResponse
    {
        return response()->json(['deleteStatus' => $deleteStatus, 'error' => $error, 'message' => $mess]);
    }
}
