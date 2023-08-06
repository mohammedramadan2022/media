<x-model-index-page model="subject" :collection="$subjects">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($subjects as $i => $subject)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($subject->name) !!}</td>
            <td><x-table-switch-status :model="$subject"></x-table-switch-status></td>
            <td>{{ $subject->since }}</td>
            <td>{{ $subject->last_update }}</td>
            <td><x-table-actions modelName="subject" :model="$subject"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
