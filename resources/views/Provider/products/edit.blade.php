@extends('Provider.layouts.master')

@section('title', transEdit('product'))

@section('style')
    {!! script('admin/assets/js/pages/editor_ckeditor.js') !!}
@stop

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
            @if('product' == 'doctor')
                <li class="breadcrumb-item">
                    <a href="{{ route('provider.'.plural('product').'.active') }}">
                        @lang('back.' . plural('product') . '.' . plural('product'))
                    </a>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ route('provider.'.plural('product').'.index') }}">
                        @lang('back.' . plural('product') . '.' . plural('product'))
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ transEdit('product') }}</li>
        </ol>
    </nav>
    <div class="card border main-border-color">
        <div class="card-header main-background-color text-white">{{ transEdit('product') }}</div>
        {!! Form::model($currentModel, [
            'url'    => route('provider.products.update', $currentModel->id),
            'method' => 'PUT',
            'id'     => 'ProductForm',
            'class'  => 'form-horizontal push-10-t products ajax edit',
            'files'  => true,
        ]) !!}

        <div class="card-body">
            @include('Back.includes.flash')

            <div class="row">
                <div class="justify-content-md-center col-md-12">
                    @include('Provider.products.form')
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
