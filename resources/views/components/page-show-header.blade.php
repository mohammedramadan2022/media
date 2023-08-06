<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <x-page-title :title="ucwords($title)"></x-page-title>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb" style="float: {{ floating('right','left') }};">
            <li><a href="{{ route('admin-panel') }}"><i class="icon-home2 position-left"></i> @lang('back.home')</a></li>
            <li><a href="{{ route(str()->plural($model).'.index') }}"><i class="icon-{{ models($model)['icon'] }} position-left"></i> @lang('back.'.str()->plural($model))</a></li>
            <li class="active">{{ $title }}</li>
        </ul>

        @include('Back.includes.quick-links')
    </div>
</div>
<!-- /page header -->
