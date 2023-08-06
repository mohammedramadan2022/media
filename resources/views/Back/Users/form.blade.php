<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="text" name="first_name" slug="form-first-name"></x-form.inputs>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="text" name="last_name" slug="form-last-name"></x-form.inputs>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="text" name="phone" slug="form-phone"></x-form.inputs>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="email" name="email" slug="form-email"></x-form.inputs>
        </div>
    </div>
</div>

@if(Route::is('users.create'))
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <x-form.inputs type="password" name="password" slug="form-password"></x-form.inputs>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <x-form.inputs type="password_confirmation" name="password" slug="form-password"></x-form.inputs>
            </div>
        </div>
    </div>
@endif

<div class="form-group">
    <x-form.input-image name="image" :model="$currentModel ?? null"></x-form.input-image>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
