@extends('Back.layouts.master')

@section('title', trans('back.my-account'))

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('back.my-account')</li>
        </ol>
    </nav>
    <div class="card border main-border-color">
        <div class="card-header main-background-color text-white">@lang('back.admins.t-admin')</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 card-box">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link text-center active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">@lang('back.profile')</a>
                        <a class="nav-link text-center" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">@lang('back.settings.settings')</a>
                        <a class="nav-link text-center" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form-20').submit();">
                            @lang('back.logout')
                        </a>

                        <form id="logout-form-20" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <div class="col-md-9 card-box">
                    @include('includes.flash')
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-box">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h4 class="text-muted">@lang('back.form-name')</h4>
                                                <h5>{{ $auth->name }}</h5>
                                            </li>

                                            <li class="list-group-item">
                                                <h4 class="text-muted">@lang('back.form-phone')</h4>
                                                <h5>{{ $auth->phone ?? trans('back.no-value') }}</h5>
                                            </li>

                                            <li class="list-group-item">
                                                <h4 class="text-muted">@lang('back.since')</h4>
                                                <h5>{{ $auth->since }}</h5>
                                            </li>

                                            <li class="list-group-item">
                                                <h4 class="text-muted">@lang('back.form-status')</h4>
                                                <h5>{{ $auth->status == 1 ? trans('back.active') : trans('back.disactive') }}</h5>
                                            </li>

                                            <li class="list-group-item">
                                                <h4 class="text-muted">@lang('back.form-email')</h4>
                                                <h5>{{ $auth->email }}</h5>
                                            </li>

                                            <li class="list-group-item">
                                                <h4 class="text-muted">@lang('back.roles.t-role')</h4>
                                                <h5>{{ $auth->role->name }}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="card-box">
                                {!! Form::model($auth, ['route' => 'admins.admin-profile-update', 'method' => 'POST', 'class' => 'ajax edit', 'files' => true]) !!}
                                    <div class="form-group form-valid">
                                        {!! Form::label(trans('back.form-name')) !!}
                                        {!! Form::text('name', null, ['class' => 'form-control form-data']) !!}
                                    </div>

                                    <div class="form-group form-valid">
                                        {!! Form::label(trans('back.form-email')) !!}
                                        {!! Form::text('email', null, ['class' => 'form-control form-data']) !!}
                                    </div>

                                    <div class="form-group form-valid">
                                        {!! Form::label(trans('back.form-phone')) !!}
                                        {!! Form::text('phone', null, ['class' => 'form-control form-data']) !!}
                                    </div>

        {{--                            <div class="form-group form-valid">--}}
        {{--                                {!! Form::label(trans('back.form-country-code')) !!}--}}
        {{--                                {!! Form::select('country_code', $countries, null, ['class' => 'form-control select2 form-data', 'dir' => direction(), 'id' => 'country_code']) !!}--}}
        {{--                            </div>--}}

                                    <div class="form-group form-valid">
                                        <label for="password">@lang('back.form-password')</label>
                                        <input type="password" name="password" class="form-control form-data" id="password">
                                    </div>

                                    <div class="form-group form-valid">
                                        <label for="image">@lang('back.form-image')</label>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <input type="file" class="dropify form-data" id="image" name="image" data-height="300" />
                                            </div>
                                            <div class="col-md-3">
                                                <div class="img-container">
                                                    <img id="viewImage" class="img-responsive" width="200" height="200" src="{{ $auth->image_url }}" alt=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-main-color">@lang('back.save')</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
