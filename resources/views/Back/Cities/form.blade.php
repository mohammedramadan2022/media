<x-form.inputs type="translation" name="city"></x-form.inputs>

<div class="form-group">
    <x-form.inputs type="text" name="address" slug="cityAddresses.t-cityAddress"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="text" name="phone" slug="form-phone"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.input-image name="image" :model="$currentModel ?? null"></x-form.input-image>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
