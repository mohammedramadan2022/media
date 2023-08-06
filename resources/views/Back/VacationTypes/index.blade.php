<x-model-index-page model="vacationType" :collection="$vacationTypes">
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
    @foreach($vacationTypes as $i => $vacationType)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($vacationType->name) !!}</td>
            <td><x-table-switch-status :model="$vacationType"></x-table-switch-status></td>
            <td>{{ $vacationType->since }}</td>
            <td>{{ $vacationType->last_update }}</td>
            <td><x-table-actions modelName="vacationType" :model="$vacationType"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
