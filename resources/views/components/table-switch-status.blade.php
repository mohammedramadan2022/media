@props(['model'])

<div id="#checkbox-{{$model->id}}">
    <label>
        <input
            type="checkbox"
            class="form-control"
            onclick="isChecked('{{ $model->status ? 'checked' : 'null' }}', '{{ $model->id }}');"
            data-plugin="switchery"
            id="active-id-{{ $model->id }}" {{ $model->status ? 'checked' : '' }}
            name="status"
            value="{{ $model->status }}"
            data-color="#5f634a"/>
    </label>
</div>
