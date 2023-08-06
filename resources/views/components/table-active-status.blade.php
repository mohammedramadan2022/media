@props(['status'])

@if($status == 1)
    <label class="badge badge-success display-block f-16 p-2">@lang('back.active')</label>
@else
    <label class="badge badge-danger display-block f-16 p-2">@lang('back.disactive')</label>
@endif
