<x-model-index-page model="provider" :collection="$providers">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-identity')</th>
            <th>@lang('back.form-email')</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($providers as $i => $provider)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($provider->name) !!}</td>
            <td>{!! highlightText($provider->identity) !!}</td>
            <td>{!! highlightText($provider->email) !!}</td>
            <td><x-image-link :imageUrl="$provider->logo_url" width="80" height="50"></x-image-link></td>
            <td><x-table-switch-status :model="$provider"></x-table-switch-status></td>
            <td>{{ $provider->since }}</td>
            <td>{{ $provider->last_update }}</td>
            <td><x-table-actions modelName="provider" :model="$provider"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
