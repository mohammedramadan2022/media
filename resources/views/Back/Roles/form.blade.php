<x-form.inputs type="translation" name="role"></x-form.inputs>

@include('Back.includes.permissions', ['role' => $currentModel ?? null])

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
