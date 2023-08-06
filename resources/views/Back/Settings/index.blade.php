@extends('Back.layouts.master')

@section('title', trans('back.settings.settings'))

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('back.settings.settings')</li>
        </ol>
    </nav>
    <div class="card-box" dir="{{ direction() }}" style="margin: 20px;">

        <div class="card-header main-background-color text-white">@lang('back.settings.settings')</div>

        <div class="card-body">
            {{ Form::open(['route' => 'settings.update-all', 'method' => 'POST', 'files' => true, 'id' => 'update-all-form', 'class' => 'ajax edit settings']) }}

            @if($settings->pluck('type')->unique()->chunk(1)->count() > 1)
                <ul class="nav nav-tabs">
                    @foreach($settings->pluck('type')->unique()->chunk(1) as $ii => $vv)
                        <li class="nav-item">
                            <a href="#fields-{{$ii}}" data-toggle="tab" aria-expanded="false" class="nav-link {{ $loop->first ? 'active' : '' }}">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">{{ trans('back.'.$vv->first()) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="tab-content">
                @foreach($settings->pluck('type')->unique()->chunk(1) as $jj => $chunk)
                    <div role="tabpanel" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="fields-{{$jj}}">
                        @include('Back.includes.settingsTab', ['chunk' => $chunk, 'settings' => $settings])
                    </div>
                @endforeach

                <x-progress-bar color="bg-primary"></x-progress-bar>
            </div>
            {{ Form::close() }}
            <input type="submit" form="update-all-form" name="submit" class="btn btn-lg text-white btn-main-color" value="@lang('back.save')"/>
        </div>
    </div>
@stop
