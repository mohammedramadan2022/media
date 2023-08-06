@extends('Back.layouts.master')

@section('title', $date->format('d-m-Y'))

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('back.dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">@lang('back.activities.activities')</a></li>
                            <li class="breadcrumb-item active">{{ $date->format('Y-m-d') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="timeline" dir="ltr">
                    <article class="timeline-item">
                        <h2 class="m-0 d-none">&nbsp;</h2>
                        <div class="time-show mt-0">
                            <a href="javascript:void(0);" class="btn btn-danger width-lg">
                                {{ $date->isToday() ? trans('back.today') : $date->format('Y-m-d') }}
                            </a>
                        </div>
                    </article>
                    @forelse($activities as $index => $activity)
                        <article class="timeline-item @if($index % 2 == 0) timeline-item-left @endif">
                            <div class="timeline-desk">
                                <div class="timeline-box">
                                    <span class="arrow{{ $index % 2 == 0 ? '-alt' : '' }}"></span>
                                    <span class="timeline-icon"><i class="mdi mdi-adjust"></i></span>
                                    <h4 class="mt-0 font-16">{{ $activity->created_at->diffForHumans() }}</h4>
                                    <p class="text-muted"><small>{{ $activity->created_at->format('h:i a') }}</small></p>
                                    <p dir="rtl" class="mb-0 lead text-justify" style="width: 609px;">{{ ucwords($activity->description) }}</p>
                                    <br/>
                                    <a href="{{ route('activities.show', $activity->id) }}">@lang('back.more')</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="alert alert-info text-center">@lang('back.no-value')</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop
