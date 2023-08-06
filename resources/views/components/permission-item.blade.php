<div class="row">
    <div class="col-md-9 f-15">
        @lang('crud.' . $value)
    </div>
    <div class="col-md-3">
        <input
            type="checkbox"
            class="form-control form-data"
            data-plugin="switchery"
            id="permissions_{{$key}}"
            name="permissions[]"
            @isset($role) {{ edit_permissions($role->permissions, $value) }} @endisset
            value="{{$value}}"
            data-color="#00b19d"/>
    </div>
</div>
