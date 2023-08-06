<?php

namespace App\Facade\Support\Tools;

use App\Facade\Support\Core\ApiResponse;
use BadMethodCallException;
use Illuminate\Support\Str;

class Success
{
    public static function __callStatic($name, $arguments)
    {
        $trans = 'api.'.snake($name)->slug();

        if (trans($trans) === $trans) {
            throw new BadMethodCallException("Method [$name] does not exist on lang/api.php.");
        }

        if (Str::contains(request()->url(), 'api')) {
            return ApiResponse::success(trans($trans));
        }

        return CrudMessage::success(trans($trans));
    }
}
