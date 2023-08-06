<x-show-element-layout :title="$category->name" model="category" nameSpace="back">
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-image')</h4>
                        <x-image-link :imageUrl="$category->image_url" width="200"></x-image-link>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-name')</h4>
                        <h5>{{ $category->name ?? trans('back.no-value')  }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.sections.t-section')</h4>
                        <h5>{{ $category->section->name ?? trans('back.no-value')  }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-status')</h4>
                        <x-table-switch-status :model="$category"></x-table-switch-status>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.since')</h4>
                        <h5>{{ $category->since }}</h5>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-show-element-layout>
