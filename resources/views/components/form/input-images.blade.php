@props(['model' => null, 'name' => 'images'])

@isset($model)
    <div class="row">
        <div class="col-md-6">
            <input
                type="file"
                accept="image/*"
                multiple
                data-show-errors="true"
                data-errors-position="outside"
                class="dropify form-data"
                id="{{$name}}"
                name="{{$name}}[]"
                data-height="300" />
        </div>
        <div class="col-md-6">
            <div class="img-container">
                <img id="viewImage" class="img-responsive" width="300" height="300" src="{{ $model->first_image_url }}" alt=""/>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-6 form-valid">
            <input
                type="file"
                multiple
                accept="image/*"
                data-show-errors="true"
                data-errors-position="outside"
                class="dropify form-data"
                id="{{$name}}"
                name="{{$name}}[0]"
                data-height="300" />
        </div>
    </div>
@endisset
