<x-form.inputs type="translation" name="section"></x-form.inputs>

<div class="form-group">
    <x-form.input-select-icon :model="$currentModel ?? null" :icons="$icons" col="icon"></x-form.input-select-icon>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
