<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="map" style="height: 500px;"></div>

    <script>
        // Initialize the map with PHP-provided latitude and longitude, or default values
        var map = L.map('map').setView([{{ $lat ?? 24.7254554 }}, {{ $long ?? 47.1521883 }}], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Initialize the marker with the initial latitude and longitude
        var marker = L.marker([{{ $lat ?? 24.7254554 }}, {{ $long ?? 47.1521883 }}]).addTo(map);

        // Function to update the marker position and center the map
        function updateMarker(latitude, longitude) {
            if (latitude && longitude) {
                marker.setLatLng([latitude, longitude]);
                map.setView([latitude, longitude], map.getZoom()); // Center map on the new marker position
                console.log('Marker updated to:', latitude, longitude);
            } else {
                console.error('Invalid latitude or longitude:', latitude, longitude);
            }
        }

        // Set up WebSocket connection
        var ws = new WebSocket('ws://localhost:8080');

        ws.onopen = function() {
            console.log('Connected to WebSocket server');
        };

        ws.onmessage = function(event) {
            try {
                var data = JSON.parse(event.data);
                if (data.latitude && data.longitude) {
                    updateMarker(data.latitude, data.longitude);
                } else {
                    console.error('Invalid data received from WebSocket:', data);
                }
            } catch (error) {
                console.error('Error parsing WebSocket message:', error);
            }
        };

        ws.onclose = function() {
            console.log('Disconnected from WebSocket server');
        };

        ws.onerror = function(error) {
            console.error('WebSocket error:', error);
        };

        // Function to fetch the latest location data every 5 seconds
        function fetchLocation() {
            fetch(`/api/latest-location/{{ $delegateId }}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.latitude !== undefined && data.longitude !== undefined) {
                        updateMarker(data.latitude, data.longitude);
                        console.log('Fetched location:', data.latitude, data.longitude);
                    } else {
                        console.error('Invalid data received from API:', data);
                    }
                })
                .catch(error => console.error('Error fetching location:', error));
        }

        // Fetch the location every 5 seconds
        setInterval(fetchLocation, 5000);

        // Function to update the location using the API
        function updateLocation(delegateId, latitude, longitude) {
            fetch(`/api/update-location/${delegateId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Location updated successfully:', data);
                } else {
                    console.error('Failed to update location:', data);
                }
            })
            .catch(error => {
                console.error('Error updating location:', error);
            });
        }

        // Example usage: Update the location to new coordinates
        // Replace with actual values as needed
        updateLocation(5, 42.712776, -70.005974); // Example coordinates for New York City
    </script>
</body>
</html>
