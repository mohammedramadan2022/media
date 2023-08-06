@props(['model', 'icons', 'col'])

<div class="col-xs-12">
    <label for="{{ $col }}">@lang('back.form-icon')</label>

    <select
        name="{{ $col }}"
        id="{{ $col }}"
        class="icons_select2 form-control form-data"
        data-size="auto"
        title="@lang('back.select-a-value')">
        @foreach($icons as $icon)
            <option
                @isset($model) {{ $model->$col == $icon->class ? 'selected' : '' }} @endisset
                data-icon="{{ $icon->class }}"
                value="{{ $icon->class }}">
                {{ str($icon->name)->replace('-', ' ')->title() }}
            </option>
        @endforeach
    </select>
</div>
