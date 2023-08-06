<ul class="icons-list">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

        <ul class="dropdown-menu dropdown-menu-{{ floating('right', 'left') }}">
            <li><a href="{{ route($route.'.edit', $model->id) }}"><i class="icon-database-edit2"></i>@lang('back.edit')</a></li>
            <li>
                <a data-id="{{ $model->id }}" class="delete-action" href="{{ localeUrl('/admin-panel/'.$route.'/'.$model->id) }}">
                    <i class="icon-database-remove"></i>@lang('back.delete')
                </a>
            </li>
        </ul>
    </li>
</ul>
