@props(['table', 'model'])

<a data-toggle="tooltip" title="@lang('back.restore')" href="{{ route($table.'.restore', ['id' => $model->id]) }}" class="btn btn-success">
    <i class="fa fa-trash-restore fa-1x"></i>
</a>

<a data-toggle="tooltip" title="@lang('back.force-delete')" href="{{ route($table.'.delete', ['id' => $model->id]) }}" class="btn btn-danger force-delete-btn">
    <i class="fa fa-trash fa-1x"></i>
</a>
