<!DOCTYPE html>
<html>
    <head>
        <style>
            #map {height: 400px; width: 400px;}
            h3 {font-family: Tahoma; margin: 0;}
            p {font-family: Tahoma; font-size: 10pt; margin: 0 0 20px 0;}
        </style>

        <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyCxLH5p73-A7s-WSdi3rcBgOF-dNd6KX_8"></script>
    </head>

    <body>
        <h3>Find nearest public toilet based on user location</h3>
        <p id="console"></p>

        <!-- DRAW MAP -->
        <div id="map"></div>

        <script>
            var console = document.getElementById("console");
            console.innerHTML = "Getting user location...";

            var userLocation;
            window.onload = function() {
                navigator.geolocation.getCurrentPosition(function(position) {
                    userLocation = new google.maps.LatLng({lat: position.coords.latitude, lng: position.coords.longitude});
                    findNearest();
                });
            };

            function findNearest() {
                console.innerHTML = "Finding nearest...";

                // toilets to test (to be pulled dynamically)
                var toilets = [
                    {lat: -37.81823386, lng: 144.9669741},
                    {lat: -37.80981201, lng: 144.9628186},
                    {lat: -37.81195695, lng: 144.9561421},
                    {lat: -37.81532739, lng: 144.9668406}
                ];

                // test current location against toilet locations in array to find nearest
                var smallestDistance = Number.MAX_VALUE;
                var nearestToilet = toilets[0];
                for (i = 0; i < toilets.length; i++) {
                    var toilet = new google.maps.LatLng({lat: toilets[i].lat, lng: toilets[i].lng});
                    var newDistance = google.maps.geometry.spherical.computeDistanceBetween(userLocation, toilet);
                    if (newDistance < smallestDistance) {
                        smallestDistance = newDistance;
                        nearestToilet = toilet;
                    }
                }

                console.innerHTML = "Generating directions...";

                // display directions on map
                var directionsDisplay;
                var directionsService = new google.maps.DirectionsService();
                var map;

                initialize();
                calcRoute();

                function initialize() {
                    directionsDisplay = new google.maps.DirectionsRenderer();
                    var mapOptions = {
                        zoom:7,
                        center: userLocation
                    }
                    map = new google.maps.Map(document.getElementById('map'), mapOptions);
                    directionsDisplay.setMap(map);
                }

                function calcRoute() {
                    var request = {
                        origin: userLocation,
                        destination: nearestToilet,
                        travelMode: 'WALKING'
                    };
                    directionsService.route(request, function(result, status) {
                        if (status == 'OK') {
                            directionsDisplay.setDirections(result);
                        }
                    });
                }
            }
        </script>
    </body>
</html>