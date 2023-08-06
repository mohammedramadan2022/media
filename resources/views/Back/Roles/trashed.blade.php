<x-model-trashed-page model="role">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.deleted_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr id="role-row-{{ $deleted->id }}">
            <td>{{ $key+1 }}</td>
            <td>{{ $deleted->name ?? trans('back.no-value') }}</td>
            <td><x-table-active-status :status="$deleted->status"></x-table-active-status></td>
            <td>{{ $deleted->created_at->diffForHumans() }}</td>
            <td>{{ $deleted->deleted_at->diffForHumans() }}</td>
            <td class="text-center">
                <x-trash-menu table="roles" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
