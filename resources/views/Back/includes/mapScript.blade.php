<script>
    let map, marker, input, searchBox;

    let lati = parseFloat("{{ (isset($currentModel) ? $currentModel->lat : 30.044420) }}");

    let lngi = parseFloat("{{ (isset($currentModel) ? $currentModel->lng : 31.235712) }}");

    let mapEl = document.getElementById('map');

    function initMap()
    {
        map = new google.maps.Map(mapEl, { center: {lat: lati, lng: lngi }, zoom: 17 });

        marker = new google.maps.Marker({ position: {lat: lati, lng: lngi}, map: map, draggable :true });

        var input = document.getElementById('searchmap');

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', placeChanged);

        google.maps.event.addListener(marker,'position_changed', positionChanged);
    }

    let positionChanged = function () {
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();

        $('#searchmap').val(marker.getPosition().title);
        $('#latitude').val(lat);
        $('#longitude').val(lng);

        displayLocation(lat,lng);
    };

    let placeChanged = function () {
        let place = autocomplete.getPlace();

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
            map.setZoom(8); // Why 17? Because it looks good.
        }

        let bounds = new google.maps.LatLanBounds();

        //set marker position new ...
        for (var i = 0; place = places[i]; i++)
        {
            bounds.extend(place.geometry.Location);
        }

        $('#latitude').val(places.geometry.location.lat());
        $('#longitude').val(places.geometry.location.lng());

        map.fitBounds(bounds);
        map.setZoom(9);
    };
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{getSetting('map_api')}}&libraries=places&callback=initMap"></script>
