@extends('Back.layouts.master')

@section('title', trans('back.create-var',['var'=>trans('back.setting')]))

@section('style')
    <script type="text/javascript" src="{{ asset('public/assets/js/plugins/forms/selects/select2.min.js') }}"></script>
@stop

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <i class="icon-arrow-right6 position-left"></i>
                    <span class="text-semibold">@lang('back.home')</span> - @lang('back.create-var',['var'=>trans('back.setting')])
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb" style="float: {{ floating('right','left') }};">
                <li><a href="{{ url('/admin-panel') }}"><i class="icon-home2 position-left"></i> @lang('back.home')</a></li>
                <li><a href="{{ url('/admin-panel/settings') }}"><i class="icon-gear position-left"></i> @lang('back.settings')</a></li>
                <li class="active">@lang('back.create-var',['var'=>trans('back.setting')])</li>
            </ul>

            @include('Back.includes.quick-links')
        </div>
    </div>
    <!-- /page header -->
    <div class="panel panel-flat content">
        {!! Form::open(formCreateArray('settings')) !!}

        <div class="panel-body">
            @include('Back.includes.flash')
            <div class="block block-rounded">
                <div class="block-header bg-smooth-dark col-md-10 col-md-offset-1">
                    @include('Back.Settings.form')
                </div>
            </div>
        </div>

        <div class="panel-footer"><input type="submit" name="submit" class="btn btn-main-color" value="@lang('back.save')"></div>

        {!! Form::close() !!}
    </div>
@stop
