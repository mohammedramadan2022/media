<x-show-element-layout :title="$vacation->name" model="vacation" nameSpace="back">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <a href="{{ $vacation->admin->image_url }}" class="image-popup-vertical-fit">
                    <img class="card-img-top img-fluid" src="{{ $vacation->admin->image_url }}" width="100" height="50" alt="image">
                </a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('admins.show', $vacation->admin_id) }}">
                            {{ ucwords($vacation->admin->name) }}
                        </a>
                    </h4>
                    <a href="{{ route('admins.edit', $vacation->admin_id) }}" class="btn btn-block btn-primary">@lang('back.edit')</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="well">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.vacationTypes.t-vacationType')</h4>
                        <h5>{{ $vacation->vacationType->name ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-days')</h4>
                        <h5>{{ $vacation->days ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-reason')</h4>
                        <h5>{{ $vacation->reason ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-from')</h4>
                        <h5>{{ $vacation->from->format('Y-m-d') ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-to')</h4>
                        <h5>{{ $vacation->to->format('Y-m-d') ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.accept-status')</h4>
                        @if(is_null($vacation->is_accepted))
                            <a href="{{ route('vacations.accept', $vacation->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                            <a href="{{ route('vacations.refuse', $vacation->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                        @elseif($vacation->is_accepted == 1)
                            <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                        @else
                            <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                        @endif
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.since')</h4>
                        <h5>{{ $vacation->since }}</h5>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-show-element-layout>
