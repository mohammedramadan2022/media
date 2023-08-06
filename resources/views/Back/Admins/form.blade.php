<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="text" name="name" slug="form-name"></x-form.inputs>
        </div>

        <div class="form-group">
            <x-form.inputs type="email" name="email" slug="form-email"></x-form.inputs>
        </div>

        <div class="form-group">
            <x-form.inputs type="tel" name="phone" slug="form-phone"></x-form.inputs>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="password" name="password" slug="form-password"></x-form.inputs>
        </div>
        <div class="form-group">
            <x-form.inputs type="password_confirmation" name="password" slug="form-password"></x-form.inputs>
        </div>
        <div class="form-group">
            <x-form.select-input :arr="$roles" name="role_id" slug="permissions.t-permission"></x-form.select-input>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <x-form.input-image name="image" :model="$currentModel ?? null"></x-form.input-image>
        </div>
    </div>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
