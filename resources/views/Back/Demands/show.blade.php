<x-show-element-layout :title="$demand->name" model="demand" nameSpace="back">
    <div class="col-md-12">
        <div class="well">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.form-logo')</h4>
                    <x-image-link :imageUrl="$demand->logo_url" width="200"></x-image-link>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.form-name')</h4>
                    <h5>{{ $demand->name ?? trans('back.no-value') }}</h5>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.form-email')</h4>
                    <h5>{{ $demand->email ?? trans('back.no-value') }}</h5>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.form-identity')</h4>
                    <h5>{{ $demand->identity ?? trans('back.no-value') }}</h5>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.form-phone')</h4>
                    <h5>{{ $demand->phone ?? trans('back.no-value') }}</h5>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.form-store-name')</h4>
                    <h5>{{ $demand->store_name ?? trans('back.no-value') }}</h5>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.cities.t-city')</h4>
                    <h5>{{ $demand->city->name ?? trans('back.no-value') }}</h5>
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.accept-status')</h4>
                    @if(is_null($demand->is_accepted))
                        <a href="{{ route('demands.accept', $demand->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                        <a href="{{ route('demands.reject', $demand->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                    @elseif($demand->is_accepted == 1)
                        <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                    @else
                        <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                    @endif
                </li>

                <li class="list-group-item">
                    <h4 class="text-muted">@lang('back.since')</h4>
                    <h5>{{ $demand->since }}</h5>
                </li>
            </ul>
        </div>
    </div>
</x-show-element-layout>
