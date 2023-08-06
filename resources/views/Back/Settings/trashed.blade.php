<x-model-trashed-page model="setting">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-key')</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.deleted_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr id="setting-row-{{ $deleted->id }}">
            <td>{{ $key+1 }}</td>

            <td>{{ $deleted->key ?? trans('back.no-value') }}</td>

            <td>{{ $deleted->name ?? trans('back.no-value') }}</td>

            <td>{{ $deleted->since }}</td>

            <td>{{ $deleted->deleted_since }}</td>

            <td class="text-center">
                <x-trash-menu table="settings" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
