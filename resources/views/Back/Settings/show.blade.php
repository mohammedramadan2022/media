<x-model-show-element :title="$setting->name" model="setting" nameSpace="back">
    <div class="col-md-12">
        <div class="card border main-border-color">
            <div class="card-header main-background-color text-white">@lang('back.settings.t-setting')</div>
            <div class="card-body">
                @include('includes.flash')
                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-key')</h4>
                                    <h5><code>{{ $setting->key }}</code></h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-name')</h4>
                                    <h5>{{ $setting->name ?? trans('back.no-value')  }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-value')</h4>
                                    @if($setting->input == 2)
                                        <img src="{{ asset('storage/uploaded/settings/'.$setting->value) }}" width="300" height="250" alt="">
                                    @elseif(is_url($setting->value))
                                        <a href="{{ url($setting->value) }}" target="_blank" style="font-size: 25px;">{{ $setting->value }}</a>
                                    @else
                                        <h5>{!! $setting->value ?? trans('back.no-value')  !!}</h5>
                                    @endif
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-status')</h4>
                                    <h5><x-table-switch-status :model="$setting"></x-table-switch-status></h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.since')</h4>
                                    <h5>{{ $setting->since }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.updated_at')</h4>
                                    <h5>{{ $setting->last_update }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-model-show-element>
