<x-model-index-page model="feature" :collection="$features">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($features as $i => $feature)
        <tr>
            <td>{{$i+1}}</td>
            <td><x-image-link :imageUrl="$feature->image_url" style="width: 8%;"></x-image-link></td>
            <td><x-table-switch-status :model="$feature"></x-table-switch-status></td>
            <td>{{ $feature->since }}</td>
            <td>{{ $feature->last_update }}</td>
            <td><x-table-actions modelName="feature" :model="$feature"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
