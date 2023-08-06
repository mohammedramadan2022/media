@extends('Provider.layouts.master')

@section('title', transCreate('product'))

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('provider-panel') }}">@lang('back.dashboard')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('provider.'.plural('product').'.index') }}">
                    {{ trans('back.'.plural('product').'.'.plural('product')) }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ transCreate('product') }}</li>
        </ol>
    </nav>

    <div class="card border main-border-color">
        <div class="card-header main-background-color text-white">{{ transCreate('product') }}</div>

        {!! Form::open(['route' => 'provider.products.store','method' => 'POST', 'id' => 'ProductForm', 'class' => 'form-horizontal push-10-t products ajax create', 'files' => true]) !!}

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
