<x-model-index-page model="section" :collection="$sections">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-icon')</th>
            <th>@lang('back.products.products')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($sections as $i => $section)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($section->name) !!}</td>
            <td><span class="fa-2x fa {{ $section->icon }}"></span></td>
            <td><span class="badge badge-danger f-12 p-2">{{ $section->sectionProducts()->count() }}</span></td>
            <td><x-table-switch-status :model="$section"></x-table-switch-status></td>
            <td>{{ $section->since }}</td>
            <td>{{ $section->last_update }}</td>
            <td><x-table-actions modelName="section" :model="$section"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
