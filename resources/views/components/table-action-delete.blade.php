<a
    data-id="{{ $model->id }}"
    data-toggle="tooltip"
    title="@lang('back.delete')"
    onclick="event.preventDefault();"
    href="{{localeUrl('/admin-panel/'.plural($modelName).'/'.$model->id) }}"
    class="delete-action btn btn-danger">
    <i class="fa fa-trash"></i>
</a>
