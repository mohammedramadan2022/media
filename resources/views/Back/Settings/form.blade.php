<div class="form-group">
    <x-form.inputs type="text" name="key" slug="form-key"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="text" name="name" slug="form-name"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="text" name="type" slug="form-type"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.select-input name="input" :arr="$types" slug="form-input"></x-form.select-input>
</div>

<div class="form-group" id="setting_value_file" style="display: none;">
    <x-form.input-image name="value" :model="$currentModel ?? null"></x-form.input-image>
</div>

<div class="form-group" id="setting_value_text">
    <x-form.inputs type="text" name="value" slug="form-value"></x-form.inputs>
</div>

<div class="form-group" id="setting_value_textarea" style="display: none;">
    <x-form.inputs type="textarea" name="value" slug="form-value"></x-form.inputs>
</div>

<div class="form-group" id="setting_value_ckeditor" style="display: none;">
    <x-form.inputs type="ckeditor" name="value" slug="back.form-value"></x-form.inputs>
</div>

<div class="form-group" id="setting_map" style="display: none;">
    <div id="map-canvas" style="width: 100%; height: 300px;"></div>
    <input type="hidden" class="form-data" style="display: none;" id="site_map_value" name="value" value="@isset($setting) @if($setting->key == 'site_location') {{ $setting->value }} @endif @endisset">
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>

@section('scripts')
    <script>
        CKEDITOR.replace('editorfullar', { height: '400px', extraPlugins: 'forms' });
        CKEDITOR.instances.editorfullar.setData(`{!! isset($setting) ? $setting->value : '' !!}`);

        $('select#input').on('change', function() {
            let input_selected = parseInt($(this).val());

            if(input_selected === 0) // text
            {
                $('#setting_value_text').fadeIn();
                $('#setting_value_textarea').remove();
                $('#setting_value_file').remove();
                $('#setting_map').remove();
                $('#setting_value_ckeditor').remove();
            }
            else if(input_selected === 1) // textarea
            {
                $('#setting_value_text').remove();
                $('#setting_value_textarea').fadeIn();
                $('#setting_value_file').remove();
                $('#setting_map').remove();
                $('#setting_value_ckeditor').remove();
            }
            else if(input_selected === 2) // file
            {
                $('#setting_value_file').fadeIn();
                $('#setting_value_text').remove();
                $('#setting_value_textarea').remove();
                $('#setting_map').remove();
                $('#setting_value_ckeditor').remove();
            }
            else if(input_selected === 3) // map
            {
                $('#setting_value_file').remove();
                $('#setting_value_text').remove();
                $('#setting_value_textarea').remove();
                $('#setting_value_ckeditor').remove();
                $('#setting_map').fadeIn();
                $('#site_map_value').val(lati+','+lngi);
            }
            else if(input_selected === 4) // ckeditor
            {
                $('#setting_value_file').remove();
                $('#setting_value_text').remove();
                $('#setting_value_textarea').remove();
                $('#setting_value_ckeditor').fadeIn();
                $('#setting_map').remove();
            }
        });

        var map, marker, input, searchBox;

        let lati = parseFloat("{{ (isset($setting) ? ($setting->key == 'site_localtion' ? explode(',', $setting->value)[0] : 24.27978497284896) : 24.27978497284896) }}");
        let lngi = parseFloat("{{ (isset($setting) ? ($setting->key == 'site_localtion' ? explode(',', $setting->value)[0] : 43.7532958984375) : 43.7532958984375) }}");

        function initMap()
        {
            map = new google.maps.Map(document.getElementById('map-canvas'), { center: {lat: lati, lng: lngi }, zoom: 9 });

            marker = new google.maps.Marker({ position: {lat: lati, lng: lngi}, map: map, draggable :true });

            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('searchmap'));

            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', place_changed);

            google.maps.event.addListener(marker,'position_changed', position_changed);
        }

        var place_changed = function() {
            var place = autocomplete.getPlace();

            if (marker && marker.setMap) {
                marker.position = place.geometry.location;
                marker.map = map;
                marker.setPosition(place.geometry.location);
            }

            if (place.geometry.viewport)
            {
                map.fitBounds(place.geometry.viewport);
            }
            else
            {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }

            $('#site_map_value').val(place.geometry.location.lat()+','+place.geometry.location.lng());

            let bounds = new google.maps.LatLanBounds();

            var i , place;

            for (var i = 0; place = places[i]; i++) {
                bounds.extend(place.geometry.Location); //set marker position new ...
            }
            map.fitBounds(bounds);
            map.setZoom(9);
        }

        var position_changed = function(){
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            $('#site_map_value').val(lat+','+lng);
            displayLocation(lat,lng);
        };

        function displayLocation(latitude,longitude){
            var request = new XMLHttpRequest();
            var method = 'GET';
            var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+latitude+','+longitude+"&key={{getSetting('map_api') }}&language=ar";
            var async = true;
            request.open(method, url, async);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var data = JSON.parse(request.responseText);

                    if(data.status === 'REQUEST_DENIED')
                    {
                        console.log(data.error_message);
                    }
                    else
                    {
                        var address = data.results[0];
                        $('#searchmap').val(address);
                    }
                }
            };
            request.send();
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{getSetting('map_api')}}&libraries=places&callback=initMap"></script>
@stop
