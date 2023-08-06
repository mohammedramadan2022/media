@php
    $plural = plural($model ?? '');
@endphp

<div class="card-box" dir="rtl">
    <h4 class="header-title mt-0">{{ trans('back.'.$plural.'.'.$plural) }}</h4>

    @if($collection['active_'.$plural]->count() > 0)
        <div class="widget-chart text-center">
            <div id="{{ $htmlID }}" dir="rtl" style="height: 350px;" class="morris-chart"></div>
            <div class="text-center">
                <p class="text-muted font-15 font-family-secondary mb-0">
                    <span class="mx-2">
                        <i class="mdi mdi-checkbox-blank-circle text-main-color"></i>
                        {{ trans('back.active') }}
                    </span>
                    <span class="mx-2">
                        <i class="mdi mdi-checkbox-blank-circle text-main-hover-color"></i>
                        {{ trans('back.disactive') }}
                    </span>
                </p>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center" style="margin-top: 320px;">@lang('back.no-value')</div>
    @endif
</div>
