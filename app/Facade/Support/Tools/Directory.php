<?php

namespace App\Facade\Support\Tools;

use Illuminate\Support\Facades\File;

class Directory
{
    public static function files($path): array
    {
        $files = [];

        if(File::exists($path))
        {
            foreach(File::files($path) as $file)
            {
                $files[] = $file->getRelativePathName();
            }
        }

        return $files;
    }

    public static function models(): array
    {
        $models = [];

        $notIn = ['.', '..', 'Token.php', 'Chat.php', 'Fcm.php', 'Image.php', 'Code.php'];

        foreach (self::files(app_path('Models')) as $class)
        {
            if (in_array($class, $notIn) || str($class)->contains('Translation')) continue;

            $models[] = (string) str($class)->replaceLast('.php','');
        }

        return $models;
    }

    public static function migrations($model = null, $type = 'array'): array|string
    {
        $migration = ($type == 'array') ? [] : '';

        foreach (self::files(base_path('database/migrations')) as $file)
        {
            if($model && !str($file)->contains($model)) continue;

            if($type == 'array') $migration[] = migrations_path($file);

            else $migration = $file;
        }

        return $migration;
    }

    public static function migration($model): array|string
    {
        return self::migrations($model,'string');
    }
}