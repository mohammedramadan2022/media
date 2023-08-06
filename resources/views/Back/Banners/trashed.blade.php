<x-model-trashed-page model="banner">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($trashes as $key => $deleted)
        <tr id="banner-row-{{ $deleted->id }}">
            <td>{{ $key+1 }}</td>
            <td><x-image-link :imageUrl="$deleted->image_url" width="90" height="90"></x-image-link></td>
            <td><x-table-active-status :status="$deleted->status"></x-table-active-status></td>
            <td>{{ $deleted->created_at->diffForHumans() }}</td>
            <td class="text-center">
                <x-trash-menu table="banners" :model="$deleted"></x-trash-menu>
            </td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-trashed-page>
