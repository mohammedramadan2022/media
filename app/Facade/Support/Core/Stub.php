<?php

namespace App\Facade\Support\Core;

use Illuminate\Support\Facades\File;

class Stub
{
    protected static string $namespace;

    public static function of($namespace, $name, $filename, $file_path): string
    {
        static::$namespace = $namespace;

        $_namespace = str($namespace)->contains('App') ? str_replace('App','app', $namespace) : $namespace;

        $filepath = base_path_normalized("$_namespace/$file_path");

        File::ensureDirectoryExists(dirname($file_path));

        if (File::exists($filepath)) return 'File Already Exists';

        File::put($filepath, static::getFileContent($filename, $name));

        return 'File Created Successfully';
    }

    public static function createTranslatableMigration($table): void
    {
        $file_path = migrations_path(date('Y_m_d_His') . "_create_{$table}_table.php");

        File::ensureDirectoryExists(dirname($file_path));

        File::put($file_path, static::getMigrationFileContent($table));
    }

    public static function createGeneralFileTemplate($filepath, $stub): string
    {
        File::ensureDirectoryExists(dirname($filepath));

        if (File::exists($filepath)) return 'File Already Exists';

        File::put($filepath, static::cloneStubFileContent($stub));

        return 'File Created Successfully';
    }

    private static function getFileContent($filename, $name): array|bool|string
    {
        return static::getStubContent(stubs_path($filename), static::getArr($name));
    }

    private static function getStubContent($stub, $stub_vars): array|bool|string
    {
        $content = file_get_contents($stub);

        foreach ($stub_vars as $name => $value) {
            $content = str_replace('{{ ' . $name . ' }}', $value, $content);
        }

        return $content;
    }

    private static function getMigrationFileContent($table): array|bool|string
    {
        $content = static::cloneStubFileContent('migration-translation.stub');

        $content = str_replace('{{ table }}', $table, $content);

        return str_replace('{{ model }}', singular($table)->lower(), $content);
    }

    private static function cloneStubFileContent($stub): bool|string
    {
        return file_get_contents(stubs_path($stub));
    }

    public static function getArr($name): array
    {
        return [
            'namespace' => ucwords(static::$namespace),
            'class'     => ucwords($name),
            'model'     => strtolower($name),
        ];
    }
}
