<x-model-index-page model="humanResource" :collection="$humanResources">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-title')</th>
            <th>@lang('back.form-video-url')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($humanResources as $i => $file)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{!! highlightText($file->title) !!}</td>
            <td><a href="{{ $file->video_url }}">{{ $file->video_url }}</a></td>
            <td><x-table-switch-status :model="$file"></x-table-switch-status></td>
            <td>{{ $file->since }}</td>
            <td>{{ $file->last_update }}</td>
            <td><x-table-actions modelName="human_resource" :model="$file"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
