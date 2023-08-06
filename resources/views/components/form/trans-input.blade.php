@props(['type' => 'text', 'name' => 'name', 'model' => null, 'slug' => 'form-name', 'arr' => '', 'lang' => 'ar'])

<div class="form-group">
    <div class="col-md-12">
        <div class="form-valid">
            <label for="{{ $arr }}_{{ strtolower($lang) }}[{{ $name }}]">@lang('back.'.$slug) ( @lang('back.'.$lang) )</label>
            {!! Form::{$type}($arr . '_' . strtolower($lang) . '['.$name.']',isset($model) ? $model->translate($lang)->$name : null,['class' => 'form-control form-data', 'id' => $arr.'_'.$lang.'['.$name.']', 'dir' => 'rtl']) !!}
        </div>
    </div>
</div>
