<x-show-element-layout :title="$faq->question" model="faq" nameSpace="back">
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-question')</h4>
                        <h5>{{ $faq->question ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-answer')</h4>
                        <p>{{ ucwords($faq->answer) }}</p>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-status')</h4>
                        <x-table-switch-status :model="$faq"></x-table-switch-status>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.since')</h4>
                        <h5>{{ $faq->since }}</h5>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-show-element-layout>
