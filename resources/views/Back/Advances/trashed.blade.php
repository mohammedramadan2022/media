<x-model-trashed-page model="advance">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-employee')</th>
            <th>@lang('back.form-amount')</th>
            <th>@lang('back.form-installment-period')</th>
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr id="advance-row-{{ $deleted->id }}">
            <td>{{ $key+1 }}</td>
            <td>{{ ucwords($deleted->admin->name) }}</td>
            <td>{{ money($deleted->amount) }}</td>
            <td>{{ ucwords($deleted->installment_period_year) }}</td>
            <td>{{ $deleted->created_at->diffForHumans() }}</td>
            <td class="text-center">
                <x-trash-menu table="advances" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
