@props(['name', 'model', 'slug'])

<label for="{{$name}}">@lang('back.'.$slug)</label>

@isset($model)
    <div class="row">
        <div class="col-md-9">
            <div class="form-valid">
                <input
                    type="file"
                    accept="application/pdf"
                    data-show-errors="true"
                    data-errors-position="outside"
                    class="dropify form-data"
                    id="{{$name}}"
                    name="{{$name}}"
                    data-height="300" />
            </div>
        </div>
        <div class="col-md-3">
            <i class="fa fa-file-pdf fa-5x" style="margin: 142px;"></i>
        </div>
    </div>
@else
    <div class="form-valid">
        <input
            type="file"
            accept="application/pdf"
            data-show-errors="true"
            data-errors-position="outside"
            class="dropify form-data"
            id="{{$name}}"
            name="{{$name}}"
            data-height="300" />
    </div>
@endisset
