<x-model-index-page model="coupon" :collection="$coupons">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-coupon-value')</th>
            <th>@lang('back.ownership')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($coupons as $i => $coupon)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($coupon->name) !!}</td>
            <td><x-percentage-element :value="$coupon->value"></x-percentage-element></td>
            <td>{!! $coupon->ownership !!}</td>
            <td><x-table-switch-status :model="$coupon"></x-table-switch-status></td>
            <td>{{ $coupon->since }}</td>
            <td>{{ $coupon->last_update }}</td>
            <td><x-table-actions modelName="coupon" :model="$coupon"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
