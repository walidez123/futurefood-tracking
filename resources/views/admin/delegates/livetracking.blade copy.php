<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div id="map" style="height: 500px;"></div>
    <script src="{{ mix('js/app.js') }}" defer></script>

    <script>
        var map = L.map('map').setView([24.7254554, 47.1521883], 10); // Set default location and zoom level
    
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    </script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="/js/app.js"></script>
    
    <script>
        Echo.channel('delegate-location-channel')
            .listen('.delegate-location-updated', (e) => {
                if (markers[e.delegateId]) {
                    map.removeLayer(markers[e.delegateId]); // Remove the previous marker
                }
                // Add a new marker or update the existing marker
                markers[e.delegateId] = L.marker([e.latitude, e.longitude]).addTo(map);
            });
    </script>
    </script>
</body>
</html>

