<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>🌏 Google Maps Geolocation Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">




    <style>
    html {
        font-family: sans-serif;
        line-height: 1.15;
        height: 100%;
    }

    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #1a1a1a;
        text-align: left;
        height: 100%;
        background-color: #fff;
    }

    .container {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .map {
        flex: 1;
        background: #f0f0f0;
    }
    </style>
</head>

<body>
    <main class="container">
        <div id="map" class="map"></div>
    </main>



    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRlTT-DjfcAKMEY-0ePypWkjfEiKrCdyE&callback=initMap"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRlTT-DjfcAKMEY-0ePypWkjfEiKrCdyE&sensor=false">
    </script>
      <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
      <script>
    let map;
    let marker;
    var lat = 24.7212691;
    var lan = 48.0715354;

    let myLatLng = {
        lat: lat,
        lng: lan
    };
    async function initMap() {
        const {
            Map
        } = await google.maps.importLibrary("maps");
        myLatLng = {
            lat: lat,
            lng: lan
        };
        map = new Map(document.getElementById("map"), {
            center: {
                lat: -34.397,
                lng: 150.644
            },
            zoom: 8,
        });
        map.setCenter(myLatLng);
        marker = new google.maps.Marker({
            position: myLatLng,
            map: map,

        });
    }
    initMap();
    function updatePosition(newLat, newLng) {
        const latLng = {
            lat: parseFloat(newLat),
            lng: parseFloat(newLng)
        };
        marker.setPosition(latLng);
        map.setCenter(latLng);
    }

    let n = 0;


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('b8263b21fdf7fc1cf8d0', {
      cluster: 'eu'
    });
    const driverIds = [435, 440];

    driverIds.forEach(driverId => {
      alert('location.'+driverId);
          var channel = pusher.subscribe('location.${driverId}');

          channel.bind('App\\Events\\SendLocation', function(data) {
            alert('s');
              
                //  updatePosition(data.location['lat'], data.location['long']);
          });
    });



  
  </script>

   

    




</body>

</html>