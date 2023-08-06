@if($status == 1)
	<span class="badge badge-success" style="font-size: 15px; padding: 10px;">@lang('back.active')</span>
@else
	<span class="badge badge-danger" style="font-size: 15px;  padding: 10px;">@lang('back.disactive')</span>
@endif
