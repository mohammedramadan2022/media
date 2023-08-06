<x-model-index-page model="preview" :collection="$previews">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.sections.t-section')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($previews as $i => $preview)
        <tr>
            <td>{{$i+1}}</td>
            <td><x-image-link :imageUrl="$preview->image_url" width="150"></x-image-link></td>
            <td>{!! highlightText($preview->section->name) !!}</td>
            <td><x-table-switch-status :model="$preview"></x-table-switch-status></td>
            <td>{{ $preview->since }}</td>
            <td>{{ $preview->last_update }}</td>
            <td><x-table-actions modelName="preview" :model="$preview"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
