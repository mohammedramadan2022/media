@php use App\Models\Spec; @endphp

<x-show-element-layout :title="$spec->name" model="spec" nameSpace="back">
    @if($spec->options()->count() > 0 && $spec->type == 'select')
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
                <a href="#spec" data-toggle="tab" aria-expanded="false" class="nav-link active">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">@lang('back.specs.t-spec')</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#options" data-toggle="tab" aria-expanded="false" class="nav-link">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">@lang('back.options.options') ({{ $spec->options()->count() }})</span>
                </a>
            </li>
        </ul>
    @endif
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="spec">
            <div class="row">
                <div class="col-md-12">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-name')</h4>
                                <h5>{{ $spec->name ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-spec-type')</h4>
                                <h5>{{ Spec::types($spec->type) }}</h5>
                            </li>

                            @if($spec->dropdown)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-select-type')</h4>
                                    <h5>{{ Spec::dropdown($spec->dropdown) }}</h5>
                                </li>
                            @endif

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-spec-code')</h4>
                                <h5>{{ $spec->code }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $spec->since }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="options">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-name')</th>
                    @if($spec->type == 'select' && $spec->dropdown == 'color')
                        <th>@lang('back.form-value')</th>
                    @endif
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($spec->options as $i => $option)
                    @foreach($option->names as $name)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $name->name }}</td>
                            @if($spec->type == 'select' && $spec->dropdown == 'color')
                                <td><span style="padding: 10px 48px;border-radius: 10px;background-color: {{ $option->value  }};"></span></td>
                            @endif
                            <td>{{ $option->since }}</td>
                            <td>{{ $option->last_update }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-show-element-layout>
