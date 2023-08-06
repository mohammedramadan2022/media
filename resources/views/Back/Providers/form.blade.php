<div class="form-group">
    <x-form.inputs type="text" name="name" slug="form-name"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.select-input :arr="$cities" name="city_id" slug="cities.t-city"></x-form.select-input>
</div>

{{--<div class="form-group">--}}
{{--    <x-form.multi-select-input :arr="$branches" name="branches" slug="branches.branches"></x-form.multi-select-input>--}}
{{--</div>--}}

<div class="form-group">
    <x-form.inputs type="email" name="email" slug="form-email"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="text" name="identity" slug="form-identity"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="text" name="store_name" slug="form-store-name"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.input-image name="logo" :model="$currentModel ?? null"></x-form.input-image>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>

{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $("#branches").val(@json(array_keys(isset($currentModel) ? $currentModel->branches : []))).trigger('change');--}}
{{--    </script>--}}
{{--@stop--}}
