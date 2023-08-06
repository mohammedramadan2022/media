<?php

namespace App\Facade\Support\Tools;

use App\Facade\Traits\CrudResponseTrait;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CrudMessage
{
    use CrudResponseTrait;

    public static function restore($obj): RedirectResponse
    {
        return back()->with('success', translated('restore', plural_parts($obj)));
    }

    public static function remove($obj): RedirectResponse
    {
        return back()->with('success', translated('remove', plural_parts($obj)));
    }

    public static function success($message = ''): RedirectResponse
    {
        return back()->with('success', ($message == '') ? trans('api.request-done-successfully') : $message);
    }

    public static function error($e): RedirectResponse
    {
        return back()->with('danger', self::setExceptionMessage($e)->mess);
    }

    public static function danger($mess): RedirectResponse
    {
        return back()->with('danger', $mess);
    }

    public static function warningWithInput($mess, $inputs): RedirectResponse
    {
        return back()->with('danger', $mess)->withInput($inputs);
    }

    private static function setExceptionMessage($e): object
    {
        $mess = is_string($e) ? $e : getFormattedException($e);

        if ($mess == '') {
            $mess = trans('api.server-internal-error');
        }

        $code = is_string($e) ? Response::HTTP_BAD_REQUEST : Response::HTTP_INTERNAL_SERVER_ERROR;

        return (object) ['mess' => $mess, 'code' => $code];
    }
}
