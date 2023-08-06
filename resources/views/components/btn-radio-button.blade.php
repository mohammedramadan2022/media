<div>
    <label class="text-semibold">@lang('back.form-'.slug($name))</label><br>

    @php
        $is_choose = '';

        if(isset($model)) {
            $is_choose = ($model->{$col} != 0) ? 'checked' : '';
        }
    @endphp

    <div class="radio form-check-inline">
        <input type="radio" class="form-data radio-main-color" id="radio-not" value="0" name="{{ $name }}" checked>
        <label for="radio-not">@lang('back.not')</label>
    </div>

    <div class="radio form-check-inline">
        <input type="radio" class="form-data radio-main-color" id="radio-yes" value="1" name="{{ $name }}" {{ $is_choose }}>
        <label for="radio-yes">@lang('back.yes')</label>
    </div>
</div>
