@props(['name', 'model'])

<label for="{{$name}}">@lang('back.form-'.slug($name))</label>

@isset($model)
    @php $url = $name . '_url'; @endphp
    <div class="row">
        <div class="col-md-9">
            <input
                type="file"
                accept="image/*"
                data-show-errors="true"
                data-errors-position="outside"
                class="dropify form-data"
                id="{{$name}}"
                name="{{$name}}"
                data-height="300" />
        </div>
        <div class="col-md-3">
            <div class="img-container">
                <img id="viewImage"
                     class="img-responsive"
                     width="300" height="300"
                     src="{{ $model->$url }}" alt=""/>
            </div>
        </div>
    </div>
@else
    <div class="form-valid">
        <input
            type="file"
            accept="image/*"
            data-show-errors="true"
            data-errors-position="outside"
            class="dropify form-data"
            id="{{$name}}"
            name="{{$name}}"
            data-height="300" />
    </div>
@endisset
