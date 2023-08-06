<div class="btn-group dropdown">
    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle btn btn-main-color m-1" data-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-wrench"></i>&nbsp;&nbsp;<span>@lang('back.more')</span>
    </a>

    <div class="dropdown-menu dropdown-menu-left">
        @if(Route::has(plural_parts($modelName).'.edit'))
            <a class="dropdown-item" href="{{ route(plural_parts($modelName).'.edit', $model->id) }}">
                تعديل&nbsp;&nbsp;<i class="fa fa-edit"></i>
            </a>
        @endif

        @if(Route::has(plural($modelName).'.show'))
            <a class="dropdown-item" href="{{ Route::has(plural_parts($modelName).'.show') ? route(plural_parts($modelName).'.show', $model->id) : '#' }}">
                عرض&nbsp;&nbsp;<i class="fa fa-eye"></i>
            </a>
        @endif

        <a class="dropdown-item deleteModal delete-action" data-id="{{ $model->id }}" href="javascript:void(0);">
            حذف&nbsp;&nbsp;<i class="fa fa-trash"></i>
        </a>
    </div>
</div>
