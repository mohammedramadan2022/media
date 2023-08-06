@props(['model', 'name', 'slug', 'color' => 'danger'])

<p class="text-muted mt-3 mb-2">@lang('back.'.$slug)</p>
<div class="radio radio-{{$color}} form-check-inline">
    <input type="radio" id="no" value="0" name="{{ $name }}"{{ isset($model) ? (!$model->$name ? 'checked' : '') : 'checked' }}>
    <label for="no">@lang('back.not')</label>
</div>
<div class="radio radio-{{$color}} form-check-inline">
    <input type="radio" id="yes" value="1" name="{{ $name }}"{{ isset($model) ? ($model->$name ? 'checked' : '') : '' }}>
    <label for="yes">@lang('back.yes')</label>
</div>
