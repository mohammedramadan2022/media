@if($model->status)
    <label class="badge badge-success p-2 f-15">@lang('back.active')</label>
@elseif(!$model->status)
    <label class="badge badge-danger p-2 f-15">@lang('back.disactive')</label>
@else
    <label class="badge badge-warning p-2 f-15">@lang('back.no-value')</label>
@endif
