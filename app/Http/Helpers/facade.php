<?php

function arr()
{
    return app('\Illuminate\Support\Arr');
}

function uploaded()
{
    return app('\App\Facade\Support\Core\Uploaded');
}

function google_translate()
{
    return app('\Stichoza\GoogleTranslate\GoogleTranslate');
}

function collections()
{
    return app('\App\Facade\Support\Core\Collections');
}

function regex()
{
    return app('\App\Facade\Support\Core\Regex');
}

function carbon()
{
    return app('\Carbon\Carbon');
}

function saudiPhone()
{
    return app('\App\Facade\Support\Tools\MobilePhone');
}

function getId3()
{
    return app('\getID3');
}

function rates()
{
    return app('\App\Facade\Support\Tools\Rates');
}

function views_path($path = ''): string
{
    return resource_path(normalizePath('views/'.$path));
}

function routes_path($path = ''): string
{
    return base_path(normalizePath('routes/'.$path));
}

function stubs_path($path = ''): string
{
    return base_path(normalizePath('stubs/'.$path));
}

function migrations_path($path = ''): string
{
    return base_path(normalizePath('database/migrations/'.$path));
}

function base_path_normalized($path = ''): string
{
    return base_path(normalizePath($path));
}

function public_path_normalized($path = ''): string
{
    return public_path(normalizePath($path));
}

function resources_path_normalized($path = ''): string
{
    return resource_path(normalizePath($path));
}
