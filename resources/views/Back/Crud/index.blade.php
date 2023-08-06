<x-model-index-page model="client" :collection="$clients">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($clients as $i => $client)
        <tr>
            <td>{{$i+1}}</td>
            <td><x-image-link :imageUrl="$client->image_url"></x-image-link></td>
            <td><x-table-switch-status :model="$client"></x-table-switch-status></td>
            <td>{{ $client->since }}</td>
            <td>{{ $client->last_update }}</td>
            <td><x-table-actions modelName="client" :model="$client"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
