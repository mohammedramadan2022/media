<?php

namespace App\Http\Traits;

use App\Enums\SpecsEnum;
use App\Facade\Support\Core\Crud;
use App\Http\Scopes\SpecScopes;
use App\Http\Traits\Api\SpecApi;

trait SpecTrait
{
    use BasicTrait, SpecScopes, SpecApi;

    public static function getInSelectForm($name = 'name'): array
    {
        return Crud::getModelsInSelectedForm(model: self::class, name: $name, withRelations: ['translation']);
    }

    public static function types($type = null): array|string
    {
        $types = [
            SpecsEnum::TEXT    => trans('back.text'),
            SpecsEnum::BOOLEAN => trans('back.boolean'),
            SpecsEnum::SELECT  => trans('back.form-select'),
        ];

        return $type ? $types[$type] : $types;
    }

    public static function dropdown($item = null): array|string
    {
        $items = [
            SpecsEnum::TEXT     => trans('back.text'),
            SpecsEnum::CHECKBOX => trans('back.checkbox'),
            SpecsEnum::COLOR    => trans('back.color'),
        ];

        return $item ? $items[$item] : $items;
    }

    public function getOptions(): array
    {
        $arr = [];

        foreach ($this->options as $option) {
            $arr[$option->id] = $option->names->first()->name;
        }

        return $arr;
    }
}
