<x-model-trashed-page model="demand">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-email')</th>
            <th>@lang('back.form-identity')</th>
            <th>@lang('back.form-phone')</th>
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr id="demand-row-{{ $deleted->id }}">
            <td>{{ $key+1 }}</td>
            <td>{{ ucwords($deleted->name) }}</td>
            <td>{{ $deleted->email }}</td>
            <td>{{ ucwords($deleted->identity) }}</td>
            <td>{{ ucwords($deleted->phone) }}</td>
            <td>{{ $deleted->created_at->diffForHumans() }}</td>
            <td class="text-center">
                <x-trash-menu table="demands" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
