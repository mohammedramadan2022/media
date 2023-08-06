@props(['type' => 'text', 'name' => 'name', 'model' => null, 'slug' => 'form-name'])

<div class="form-group">
    <div class="col-md-12">
        <div class="form-valid">
            <label for="ar[{{ $name }}][]">@lang('back.'.$slug) ( @lang('back.ar') )</label>
            {!! Form::{$type}('ar['.$name.'][]',isset($model) ? $model->$name : null,['class' => 'form-control form-data', 'id' => 'ar['.$name.'][]', 'dir' => 'rtl']) !!}
        </div>
    </div>
</div>
