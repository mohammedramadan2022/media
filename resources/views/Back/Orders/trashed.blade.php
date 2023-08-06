<x-model-trashed-page model="order">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-order-no')</th>
            <th>@lang('back.users.t-user')</th>
            <th>@lang('back.form-price')</th>
            <th>@lang('back.form-total')</th>
            <th>@lang('back.form-subtotal')</th>
            <th>@lang('back.form-tax')</th>
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr id="order-row-{{ $deleted->id }}">
            <td>{{ $key+1 }}</td>
            <td>{{ $deleted->order_no }}</td>
            <td>{{ ucwords($deleted->username) }}</td>
            <td>{{ money($deleted->price) }}</td>
            <td>{{ money($deleted->total) }}</td>
            <td>{{ money($deleted->subtotal) }}</td>
            <td>{{ money($deleted->tax) }}</td>
            <td>{{ $deleted->created_at->diffForHumans() }}</td>
            <td class="text-center">
                <x-trash-menu table="orders" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
