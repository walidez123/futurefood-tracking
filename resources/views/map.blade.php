<!DOCTYPE html>
<html>
<head>
    <title>عرض المسار</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
   

        <div class="row mt-5">
            <div class="col-md-12">
                <h3>تفاصيل الرحلة:</h3>
                @if($data['status'] == 'OK')
                    @php
                        $route = $data['rows'][0];
                        $leg = $route['elements'][1];
                    @endphp
                    <p>المسافة: {{ $leg['distance']['text'] }}</p>
                    <p>الزمن المقدر: {{ $leg['duration']['text'] }}</p>
                    <div id="map"></div>
                @else
                    <p>حدث خطأ في تحميل البيانات.</p>
                @endif
            </div>
        </div>
</div>
    <script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10, // Adjust zoom level as needed
            center: {lat: 24.7136, lng: 46.6753} // Set the center of the map
        });
        directionsRenderer.setMap(map);

        var waypoints = [];
        var waypointAddresses = []; // Assume this array contains the addresses for your waypoints

        @foreach($data['origin_addresses'] as $address)
            waypoints.push({
                location: '{{ $address }}',
                stopover: true
            });
            waypointAddresses.push('{{ $address }}'); // Pushing addresses into the array

        @endforeach
        var originAddress = '{{ $data["origin_addresses"][0] }}';
    var destinationAddress = '{{ $data["destination_addresses"][0] }}';

    var request = {
        origin: originAddress,
        destination: destinationAddress,
        waypoints: waypoints,
        travelMode: 'DRIVING',
    };

        var request = {
            origin: '{{ $data["origin_addresses"][0] }}',
            destination: '{{ $data["destination_addresses"][0] }}',
            waypoints: waypoints,
            travelMode: 'DRIVING',
        };
        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                directionsRenderer.setDirections(result);
                addMarkerWithInfoWindow(map, result.routes[0].legs[0].start_location, originAddress);
            addMarkerWithInfoWindow(map, result.routes[0].legs[0].end_location, destinationAddress);
            
            // Add markers and info windows for waypoints
            result.routes[0].legs.forEach((leg, index) => {
                if(index < waypointAddresses.length) { // Check to avoid index out of bounds
                    addMarkerWithInfoWindow(map, leg.end_location, waypointAddresses[index]);
                }
            });
            }
        });
    }
    function addMarkerWithInfoWindow(map, position, content) {
    var marker = new google.maps.Marker({
        position: position,
        map: map
    });
    var infowindow = new google.maps.InfoWindow({
        content: content
    });
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdda6Slpqu9mvk4PVUlP6858eETZ5saDw&callback=initMap">
    </script>

</body>
</html>