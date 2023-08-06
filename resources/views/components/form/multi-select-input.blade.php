@props(['name', 'slug', 'arr'])

@include('Back.includes.inputs', [
    'type'  => 'multi-select',
    'name'  => $name,
    'list'  => count($arr) > 0 ? [0 => trans('back.select-a-value')] + $arr : [0 => trans('back.no-value')],
    'style' => 'form-control form-data',
    'slug'  => trans('back.'.$slug),
])
