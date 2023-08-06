<x-model-index-page model="faq" :collection="$faqs">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-question')</th>
            <th>@lang('back.form-answer')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($faqs as $i => $faq)
        <tr>
            <td>{{$i+1}}</td>
            <td data-toggle="tooltip" title="{{ $faq->question }}">{!! highlightText($faq->question) !!}</td>
            <td data-toggle="tooltip" title="{{ $faq->answer }}">{!! highlightText(str($faq->answer)->limit()) !!}</td>
            <td><x-table-switch-status :model="$faq"></x-table-switch-status></td>
            <td>{{ $faq->since }}</td>
            <td>{{ $faq->last_update }}</td>
            <td><x-table-actions modelName="faq" :model="$faq"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
