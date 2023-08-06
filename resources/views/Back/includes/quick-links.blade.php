<ul class="breadcrumb-elements" style="float: {{ floating('left', 'right') }};position: relative;{{ floating('left', 'right') }}: 51px;">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-gear position-left"></i>@lang('back.quick-links')
            <span class="caret"></span>
        </a>

        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="{{ route('admins.index') }}"><i class="icon-user-tie"></i> @lang('back.display-all',['var'=>trans('back.admins.admins')])</a></li>

            <li><a href="{{ route('admins.create') }}"><i class="icon-user"></i> @lang('back.create-var',['var'=>trans('back.admins.admin')])</a></li>
        </ul>
    </li>
</ul>
