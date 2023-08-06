<label for="searchmap">@lang('back.location')</label>
<input type="text" name="searchmap" id="searchmap" class="form-control"/>
<div id="map" style="width: 100%; height: 500px;"></div>
<input type="hidden" class="form-data" id="latitude" name="lat" value="{{ isset($model) ? $model->lat : 30.044420 }}">
<input type="hidden" class="form-data" id="longitude" name="lng" value="{{ isset($model) ? $model->lng : 31.235712 }}">
