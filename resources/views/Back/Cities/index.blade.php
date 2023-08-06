<x-model-index-page model="city" :collection="$cities">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-address')</th>
            <th>@lang('back.form-phone')</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($cities as $i => $city)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{!! highlightText($city->name) !!}</td>
            <td>{!! highlightText($city->address) !!}</td>
            <td>{!! highlightText($city->phone) !!}</td>
            <td><x-image-link :imageUrl="$city->image_url" width="80"></x-image-link></td>
            <td><x-table-switch-status :model="$city"></x-table-switch-status></td>
            <td>{{ $city->since }}</td>
            <td>{{ $city->last_update }}</td>
            <td><x-table-actions modelName="city" :model="$city"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
