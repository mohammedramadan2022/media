<x-model-trashed-page model="payment">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.users.t-user')</th>
            <th>@lang('back.form-amount')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.deleted_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr>
            <td>{{ $key+1 }}</td>

            <td>{{ isset($deleted->user) ? $deleted->username : trans('back.no-value') }}</td>

            <td>{{ $deleted->amount ?? trans('back.no-value') }}</td>

            <td>{{ $deleted->since }}</td>

            <td>{{ $deleted->deleted_since }}</td>

            <td class="text-center">
                <x-trash-menu table="payments" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
