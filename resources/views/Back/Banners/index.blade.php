@php use \App\Models\Banner; @endphp

<x-model-index-page model="banner" :collection="$banners">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.type')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($banners as $i => $banner)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><x-image-link :imageUrl="$banner->image_url" width="150"></x-image-link></td>
            <td>{{ Banner::types($banner->type) }}</td>
            <td><x-table-switch-status :model="$banner"></x-table-switch-status></td>
            <td>{{ $banner->since }}</td>
            <td>{{ $banner->last_update }}</td>
            <td><x-table-actions modelName="banner" :model="$banner"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>

