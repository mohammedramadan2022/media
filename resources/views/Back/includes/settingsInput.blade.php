@if($setting->input == 0)

    <div class="form-group">
        <label for="{{$setting->key}}">{{ucwords($setting->name)}}</label>
        <input
            type="text"
            class="form-control form-data"
            name="{{$setting->key}}"
            dir="{{ is_arabic_rtl($setting->value) }}"
            id="{{$setting->key}}"
            value="{{$setting->value}}">
    </div>

@elseif($setting->input == 2)
    {{--  file Type --}}
    <div class="form-group">
        <label for="{{$setting->key}}">{{ucwords($setting->name)}}</label>
        <div class="row">
            <div class="col-md-9">
                <input
                    type="file"
                    data-show-errors="true"
                    data-errors-position="outside"
                    class="dropify form-data"
                    id="{{$setting->key}}"
                    name="{{$setting->key}}"
                    data-height="300"/>
            </div>
            <div class="col-md-3">
                @if(last(explode('.', $setting->value)) !== null)
                    @if(in_array(last(explode('.', $setting->value)), getSettingsInputFiles()))
                        <img id="viewImage" class="img-responsive" width="300" height="200"
                             src="{{ asset_url('storage/uploaded/settings/'.$setting->value) }}" alt=""/>
                    @elseif(last(explode('.',$setting->value)) !== null && last(explode('.',$setting->value)) == 'pdf')
                        <i class="fa fa-file-pdf fa-5x" style="margin: 142px;"></i>
                    @endif
                @endif
            </div>
        </div>
    </div>
@elseif($setting->input == 3)
    {{--  map Type --}}

    <div id="map_{{$setting->key}}" style="width: 100%; height: 400px;"></div>
    <input type="hidden" name="searchmap" id="searchmap">
    <input type="hidden" class="form-control form-data" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $setting->value }}">
    <script>
        let map, marker, input, searchBox;

        let map_input = '{{ $setting->key }}';

        let map_api = "{{ getSetting('map_api') }}";

        let lati = parseFloat("{{ explode(',', $setting->value)[0] }}");

        let lngi = parseFloat("{{ explode(',', $setting->value)[1] }}");

        const place_changed = function () {
            var place = autocomplete.getPlace();

            if (marker && marker.setMap) {
                marker.position = place.geometry.location;
                marker.map = map;
                marker.setPosition(place.geometry.location);
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }

            $('#' + map_input).val(place.geometry.location.lat() + ',' + place.geometry.location.lng());

            let bounds = new google.maps.LatLanBounds();

            var i, place;

            for (i = 0; place = places[i]; i++) {
                bounds.extend(place.geometry.Location);
            } //set marker position new ...

            map.fitBounds(bounds);

            map.setZoom(9);
        }

        let position_changed = function () {
            let lat = marker.getPosition().lat();
            let lng = marker.getPosition().lng();
            $('#' + map_input).val(lat + ',' + lng);
            displayLocation(lat, lng);
        };

        function displayLocation(latitude, longitude) {
            let request = new XMLHttpRequest();

            let method = 'GET';

            let url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + latitude + ',' + longitude + "&key=" + map_api + "&language=ar";

            let async = true;

            request.open(method, url, async);

            request.onreadystatechange = function () {
                if (request.readyState === 4 && request.status === 200) {
                    let data = JSON.parse(request.responseText);

                    if (data.status === 'REQUEST_DENIED') {
                        console.log(data.error_message);
                    } else {
                        let address = data.results[0];
                        $('#searchmap').val(address);
                    }
                }
            };
            request.send();
        }

        function initMap() {
            map = new google.maps.Map(document.getElementById('map_{{ $setting->key }}'), {
                center: {
                    lat: lati,
                    lng: lngi
                }, zoom: 9
            });

            marker = new google.maps.Marker({position: {lat: lati, lng: lngi}, map: map, draggable: true});

            let autocomplete = new google.maps.places.Autocomplete(document.getElementById('searchmap'));

            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', place_changed);

            google.maps.event.addListener(marker, 'position_changed', position_changed);
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{getSetting('map_api')}}&libraries=places&callback=initMap"></script>

@elseif($setting->input == 5)

    {{-- switch type --}}
    <div class="form-group">
        <label for="{{$setting->key}}">{{ucwords($setting->name)}}</label><br/>
        <input
            type="checkbox"
            class="form-control form-data"
            data-plugin="switchery"
            name="{{$setting->key}}"
            id="{{$setting->key}}"
            @if((boolean)$setting->value == 1) checked="checked" @endif
            value="{{$setting->value}}"
            data-color="#00b19d"/>
    </div>

@elseif($setting->input == 6)
    {{-- Button type --}}
    <div class="form-group">
        <label for="{{$setting->key}}">{{ucwords($setting->name)}}</label><br>
        <button type="button" class="btn btn-dark" onclick="executeThis('{{$setting->value}}');">{{ucwords($setting->name)}}</button>
    </div>
@else
    {{--  textarea Type => setting input (1) --}}
    <div class="form-group">
        <label for="{{$setting->key}}">{{ucwords($setting->name)}}</label>
        <textarea
            class="form-control form-data"
            name="{{$setting->key}}"
            dir="{{ is_arabic_rtl($setting->value) }}"
            id="{{$setting->key}}"
            cols="30"
            rows="10">{{$setting->value}}</textarea>
    </div>
@endif

@section('scripts')
    <script>
        window.executeThis = function (link) {
            let deleteMessage = 'تحذير';

            let deleteMessageTitle = 'سيتم الحذف نهائيا !';

            swal(setAlertDeleteObject(deleteMessage, deleteMessageTitle)).then(function (willDelete) {
                if (!willDelete) {
                    swal(swalObjectTerminated);
                    return;
                }

                $.ajax({
                    beforeSend: () => HoldOn.open(),
                    url: link,
                    method: 'POST',
                    success: response => {
                        HoldOn.close();
                        swal({icon: 'success', title: 'رسالة', buttons: [false, "حسنا"], text: response.message});
                    },
                    error: err => swal({icon: 'success', title: 'رسالة', text: err, buttons: [false, "حسنا"]})
                });
            });
        }
    </script>
@stop
