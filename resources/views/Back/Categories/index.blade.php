<x-model-index-page model="category" :collection="$categories">
    <x-slot name="filter">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-valid">
                    <label for="city_id">@lang('back.sections.t-section')</label>
                    {!! Form::select('section_id', ['' => trans('back.select-a-value')] + $sections, request()->filled('section_id') ? request('section_id') : null, ['class' => 'form-control form-data','dir' => direction(),'id' => 'section_id']) !!}
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.sections.t-section')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($categories as $i => $category)
        <tr>
            <td>{{$i+1}}</td>
            <td>{!! highlightText($category->name) !!}</td>
            <td><x-image-link :imageUrl="$category->image_url" width="90"></x-image-link></td>
            <td>{!! highlightText($category->section->name) !!}</td>
            <td><x-table-switch-status :model="$category"></x-table-switch-status></td>
            <td>{{ $category->since }}</td>
            <td>{{ $category->last_update }}</td>
            <td><x-table-actions modelName="category" :model="$category"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
