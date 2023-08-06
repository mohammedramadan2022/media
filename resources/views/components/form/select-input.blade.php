@props(['name', 'arr', 'slug', 'selected' => null])

@include('Back.includes.inputs', [
    'type'      => 'select',
    'name'      => $name,
    'list'      => count($arr) > 0 ? ['' => trans('back.select-a-value')] + $arr : ['' => trans('back.no-value')],
    'style'     => 'form-control form-data',
    'selected'  => $selected,
    'slug'      => is_arabic($slug) ? $slug : trans('back.' . $slug),
])
