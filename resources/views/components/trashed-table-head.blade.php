<h5 class="panel-title pull-left">
    @lang('back.'.$table) ({{ $collection->count() }})
</h5>
<ul class="breadcrumb-elements pull-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-gear position-left"></i></a>

        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="{{ route($table.'.create') }}"><i class="icon-plus3"></i> @lang('back.add')</a></li>
        </ul>
    </li>
</ul>
