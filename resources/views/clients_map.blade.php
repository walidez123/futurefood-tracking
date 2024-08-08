<!DOCTYPE html>
<html>
<head>
    <title>Client Map</title>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRlTT-DjfcAKMEY-0ePypWkjfEiKrCdyE&language&callback=initMap"></script>
 
    <style>
        #map {
            height: 550px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        var clients = @json($clients);
        // console.log(clients);
    </script>

    <script>
    function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: {lat:24.770417, lng: 46.5770916} // Center the map on Saudi Arabia
            });
            // Loop through clients and add markers
            for (var i = 0; i < clients.length; i++) {
                var marker = new google.maps.Marker({

                    position: {lat: clients[i].lat, lng: clients[i].lng},
                    map: map,
                    title: clients[i].name
                });
            }
        }
    </script>
</body>
</html>
