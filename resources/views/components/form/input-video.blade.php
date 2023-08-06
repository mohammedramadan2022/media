<label for="{{$name}}">@lang('back.form-video')</label>

@if(isset($model) && $model->video_url)
    <div class="row">
        <div class="col-md-6">
            <input
                type="file"
                accept="video/*"
                data-show-errors="true"
                data-errors-position="outside"
                class="dropify form-data" id="{{$name}}"
                name="{{$name}}"
                data-height="300" />
        </div>
        <div class="col-md-6">
            <x-model-video-player :src="$model->video_url" width="350"></x-model-video-player>
        </div>
    </div>
@else
    <input
        type="file"
        accept="video/*"
        data-show-errors="true"
        data-errors-position="outside"
        class="dropify form-data" id="{{$name}}"
        name="{{$name}}"
        data-height="300" />
@endif
