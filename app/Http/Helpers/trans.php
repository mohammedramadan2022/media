<?php

function transByType($type, $model): string
{
    return trans('back.'.$type.'-var', [
        'var' => trans('back.'.plural_parts($model).'.'.plural_parts($model)->singular()),
    ]);
}

function translate($key): string
{
    return trans('back.'.plural($key).'.'.$key);
}

function transCreate($model): string
{
    return transByType('create', $model);
}

function transEdit($model): string
{
    return transByType('edit', $model);
}

function transLatest($tableName): string
{
    return transByType('latest', $tableName);
}

function transActive($model): string
{
    return transByType('active', $model);
}

function transDeductive($model): string
{
    return transByType('deductive', $model);
}

function transNoVar($var): string
{
    return trans('back.no-var', ['var' => trans($var)]);
}
