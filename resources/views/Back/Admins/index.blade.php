<x-model-index-page model="admin" :collection="$admins">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.roles.t-role')</th>
            <th>@lang('back.form-email')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($admins as $i => $admin)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{!! highlightText(ucwords($admin->name)) !!}</td>
            <td><a href="{{ route('roles.show', $admin->role_id) }}">{!! highlightText($admin->role->name) !!}</a></td>
            <td>{!! highlightText($admin->email) !!}</td>
            <td><x-table-switch-status :model="$admin"></x-table-switch-status></td>
            <td>{{ ucwords($admin->since) }}</td>
            <td><x-table-actions modelName="admin" :model="$admin"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
