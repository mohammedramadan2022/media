<td>
    <input
        type="checkbox"
        class="form-control form-data"
        onclick="isChecked('{{ $status == 1 ? 'checked' : 'null' }}', '{{ $id }}');"
        data-plugin="switchery"
        id="active-id-{{ $id }}" {{ $status == 1 ? 'checked' : '' }}
        name="status"
        value="{{$id}}"
        data-color="#00b19d"/>
</td>
