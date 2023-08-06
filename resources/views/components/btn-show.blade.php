@props(['route', 'id', 'model'])

<a
    href="{{ route($route, $id) }}"
    class="btn btn-dark"
    data-toggle="tooltip"
    title="@lang('back.show-var',['var' => trans('back.'.plural($model).'.t-'.$model)])">
    <i class="fa fa-eye"></i>
</a>
