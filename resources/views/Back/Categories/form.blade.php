<x-form.inputs type="translation" name="category"></x-form.inputs>

<div class="form-group">
    <x-form.select-input :arr="$sections" name="section_id" slug="sections.t-section"></x-form.select-input>
</div>

<div class="form-group">
    <x-form.multi-select-input :arr="$specs" name="specs" slug="specs.specs"></x-form.multi-select-input>
</div>

<div class="form-group">
    <x-form.input-image :model="$currentModel ?? null" name="image"></x-form.input-image>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
