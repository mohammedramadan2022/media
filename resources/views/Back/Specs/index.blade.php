<x-model-index-page model="spec" :collection="$specs">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($specs as $i => $spec)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($spec->name) !!}</td>
            <td><x-table-switch-status :model="$spec"></x-table-switch-status></td>
            <td>{{ $spec->since }}</td>
            <td>{{ $spec->last_update }}</td>
            <td><x-table-actions modelName="spec" :model="$spec"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
