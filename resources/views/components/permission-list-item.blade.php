<li class="list-group-item">
    <input
        type="checkbox"
        class="form-control form-data"
        data-plugin="switchery"
        @isset($role) {{ edit_permissions($role->permissions, $val) }} @endisset
        value="{{$val}}"
        @if($val == 'admins.profile' || $val == 'admins.admin-profile-update') checked @endif
        name="permissions[]"
        id="permissions_{{$k}}"
        data-color="#00b19d">
    &nbsp;&nbsp;
    <label for="permissions_{{$k}}">@lang('crud.'.$val)</label>
</li>

