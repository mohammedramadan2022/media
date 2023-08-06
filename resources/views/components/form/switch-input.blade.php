@php
    $status = isset($model) && $model->status == 1;
    [$resource, $currentRoute] = explode('.', currentRoute());
@endphp

<label for="active-id-{{ isset($model) ? $model->id : 0 }}">@lang('back.form-status')</label>

<input
    type="checkbox"
    class="form-control form-data"
    onclick="isChecked('{{ $status == 1 ? 'checked' : 'null' }}', '{{ isset($model) ? $model->id : 0 }}');"
    data-plugin="switchery"
    id="active-id-{{ isset($model) ? $model->id : 0 }}"
    name="status"
    {{ $status == 1 || $currentRoute == 'create' ? 'checked' : '' }}
    value="{{ $status || $currentRoute == 'create' ? 1 : 0 }}"
    data-color="var(--main)"/>
