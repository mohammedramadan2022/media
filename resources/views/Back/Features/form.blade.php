<div class="form-group">
    <x-form.inputs type="text" name="url" slug="form-url"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.input-image name="image" :model="$currentModel ?? null"></x-form.input-image>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
