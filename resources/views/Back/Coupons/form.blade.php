<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">@lang('back.form-name')</label>
            <div class="input-group form-valid">
                {!! Form::text('name', null, ['class' => 'form-control form-data', 'dir' => direction(), 'id' => 'name']) !!}
                <div class="input-group-append">
                    <button type="button" onclick="$('#name').val(makeid(5));" id="coupon-generator" class="btn btn-main-color">@lang('back.generate')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <x-form.inputs type="number" name="value" slug="form-percentage"></x-form.inputs>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="form-valid floating">
                    <label for="expired_at">{{ trans('back.form-expired-at') }}</label>
                    <input type="date" name="expired_at" value="{{ isset($currentModel) ? $currentModel->expired_at_formatted : '' }}" class="form-control form-data" id="expired_at">
                </div>
            </div>
        </div>

        <div class="form-group">
            <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
        </div>
    </div>
</div>
