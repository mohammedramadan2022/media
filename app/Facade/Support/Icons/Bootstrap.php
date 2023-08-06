<?php

namespace App\Facade\Support\Icons;

use App\Repository\Contracts\IFormIcons;

class Bootstrap implements IFormIcons
{
    public static function getIcons($with_null = null): array
    {
        return get_current_icon_file(offset: 2, with_null: $with_null);
    }
}
