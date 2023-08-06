@props(['type' => 'text', 'name' => 'name', 'model' => null, 'slug' => 'form-name'])

<div class="form-group">
    <div class="col-md-12">
        <div class="form-valid">
            <label for="en[{{ $name }}][]">@lang('back.'.$slug) ( @lang('back.en') )</label>
            {!! Form::{$type}('en['.$name.'][]',isset($model) ? $model->$name : null,['class' => 'form-control form-data', 'id' => 'en['.$name.'][]', 'dir' => 'rtl']) !!}
        </div>
    </div>
</div>
