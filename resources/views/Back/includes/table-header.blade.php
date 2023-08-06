<h5 class="panel-title pull-left">
    @lang('back.'.$name)
    @if($name != 'settings')
        <a href="{{ route($name.'.create') }}" class="btn btn-primary" style="margin: 5px;color: #fff;width: 71px;">+</a>
    @endif
</h5>
<ul class="breadcrumb-elements pull-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-gear position-left"></i></a>

        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="{{ route($name.'.export') }}"><i class="icon-file-excel"></i> @lang('back.export-csv')</a></li>
            @if($name != 'settings')
                <li><a href="{{ route($name.'.trashed') }}"><i class="icon-trash"></i> @lang('back.trashed')</a></li>
                <li><a href="{{ route($name.'.create') }}"><i class="icon-plus3"></i> @lang('back.add')</a></li>
            @endif
        </ul>
    </li>
</ul>
