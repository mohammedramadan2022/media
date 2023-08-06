<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            @if($type == 'trashes')
                <x-page-title :title="trans('back.trashed')"></x-page-title>
            @elseif($type == 'create')
                <x-page-title :title="trans('back.create-var',['var'=>trans('back.'.$model)])"></x-page-title>
            @else
                <x-page-title :title="trans('back.edit-var',['var'=>trans('back.'.$model)])"></x-page-title>
            @endif
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb" style="float: {{ floating('right','left') }};">
            <li><a href="{{ route('admin-panel') }}"><i class="icon-home2 position-left"></i> @lang('back.home')</a></li>
            <li><a href="{{ route(str()->plural($model).'.index') }}"><i class="icon-{{ models($model)['icon'] }} position-left"></i> @lang('back.'.str()->plural($model))</a></li>
            @if($type == 'trashes')
                <li class="active">@lang('back.trashed')</li>
            @else
                <li class="active">@lang('back.'.$type.'-var',['var'=>trans('back.'.$model)])</li>
            @endif
        </ul>

        @include('Back.includes.quick-links')
    </div>
</div>
<!-- /page header -->
