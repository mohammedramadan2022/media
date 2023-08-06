@extends('Back.layouts.master')

@section('title', transEdit($model))

@section('style')
    {!! script('admin/assets/js/pages/editor_ckeditor.js') !!}
@stop

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
            @if($model == 'doctor')
                <li class="breadcrumb-item">
                    <a href="{{ route(plural($model).'.active') }}">
                        @lang('back.' . plural($model) . '.' . plural($model))
                    </a>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ route(plural($model).'.index') }}">
                        @lang('back.' . plural($model) . '.' . plural($model))
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ transEdit($model) }}</li>
        </ol>
    </nav>
    <div class="card border main-border-color">
        <div class="card-header main-background-color text-white">{{ transEdit($model) }}</div>
        {!! Form::model($currentModel, formUpdateArray($currentModel, plural($model))) !!}

        <div class="card-body">
            @include('Back.includes.flash')

            <div class="row">
                <div class="justify-content-md-center col-md-12">
                    @include('Back.'.plural($model)->ucfirst().'.form')
                    <x-progress-bar color="bg-primary"></x-progress-bar>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white">
            <input type="submit" name="submit" class="btn btn-main-color text-white create-button" value="@lang('back.save')">
        </div>

        {!! Form::close() !!}
    </div>
@stop
