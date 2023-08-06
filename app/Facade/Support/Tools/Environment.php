<?php

namespace App\Facade\Support\Tools;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Environment
{
    private static function updateEnv($key, $newValue, $delim, $is_bool): void
    {
        $path = base_path('.env');

        $oldValue = $is_bool ? (bool) Env::get($key) : Env::get($key);

        if ($oldValue == $newValue) return;

        if (! File::exists($path)) return;

        $_new = $is_bool ? $key.'='.($newValue ? 'true' : 'false') : $key.'='.$delim.$newValue.$delim;

        $_old = $is_bool ? $key.'='.($oldValue ? 'true' : 'false') : $key.'='.$delim.$oldValue.$delim;

        File::put($path, str(File::get($path))->replace($_old, $_new));

        Artisan::call('optimize:clear');
    }

    public static function update($key, $newValue, $delim = ''): void
    {
        self::updateEnv($key, $newValue, $delim,false);
    }

    public static function updateBool($key, $newValue, $delim = ''): void
    {
        self::updateEnv($key, $newValue, $delim, true);
    }
}
