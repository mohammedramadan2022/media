<x-form.inputs type="translation" name="course"></x-form.inputs>

<div class="form-group">
    <x-form.inputs type="text" dir="ltr" name="video_url" slug="form-video-url"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>
