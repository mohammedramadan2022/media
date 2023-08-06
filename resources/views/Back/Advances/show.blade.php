<x-show-element-layout :title="$advance->admin->name" model="advance" nameSpace="back">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <a href="{{ $advance->admin->image_url }}" class="image-popup-vertical-fit">
                    <img class="card-img-top img-fluid" src="{{ $advance->admin->image_url }}" width="100" height="50" alt="image">
                </a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('admins.show', $advance->admin_id) }}">
                            {{ ucwords($advance->admin->name) }}
                        </a>
                    </h4>
                    <a href="{{ route('admins.edit', $advance->admin_id) }}" class="btn btn-block btn-primary">@lang('back.edit')</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="well">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-installment-period')</h4>
                        <h5>{{ $advance->installment_period_year ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-amount')</h4>
                        <h5>{{ $advance->amount ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-reason')</h4>
                        <h5>{{ $advance->reason ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-date')</h4>
                        <h5>{{ $advance->date->format('Y-m-d') ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.accept-status')</h4>
                        @if(is_null($advance->is_accepted))
                            <a href="{{ route('advances.accept', $advance->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                            <a href="{{ route('advances.refuse', $advance->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                        @elseif($advance->is_accepted == 1)
                            <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                        @else
                            <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                        @endif
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.since')</h4>
                        <h5>{{ $advance->since }}</h5>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-show-element-layout>
