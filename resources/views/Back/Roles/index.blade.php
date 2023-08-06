<x-model-index-page model="role" :collection="$roles">
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
    @foreach($roles as $i => $role)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($role->name) !!}</td>
            <td><x-table-switch-status :model="$role"></x-table-switch-status></td>
            <td>{{ $role->since }}</td>
            <td>{{ $role->last_update }}</td>
            <td><x-table-actions modelName="role" :model="$role"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
