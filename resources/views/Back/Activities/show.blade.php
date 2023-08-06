<x-model-show-element :title="$activity->subject->name" model="activity" nameSpace="back">
    <div class="col-md-12">
        <div class="card border main-border-color">
            <div class="card-header main-background-color text-white">@lang('back.activities.t-activity')</div>
            <div class="card-body">
                @include('includes.flash')
                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.activities.t-activity')</h4>
                                    <h5>{{ ucwords($activity->description) }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.type')</h4>
                                    <h5>{{ trans('back.'.$activity->log_name) ?? trans('back.no-value') }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-name')</h4>
                                    <h5>
                                        @if(Route::has(getModelPluralName($activity->subject_type).'.show'))
                                            <a href="{{ route(getModelPluralName($activity->subject_type).'.show', $activity->subject_id) }}">
                                                {{ $activity->subject->name ?? trans('back.no-value') }}
                                            </a>
                                        @endif
                                    </h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.admins.t-admin')</h4>
                                    <h5>
                                        @if(auth()->guard('admin')->user()->role_id == 1)
                                            <a href="javascript:void(0);">
                                                {{ $activity->causer->name ?? trans('back.no-value') }}
                                            </a>
                                        @else
                                            <a href="{{ route('admins.show', $activity->causer_id) }}">
                                                {{ $activity->causer->name ?? trans('back.no-value') }}
                                            </a>
                                        @endif
                                    </h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.since')</h4>
                                    <h5>{{ $activity->since }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-model-show-element>
