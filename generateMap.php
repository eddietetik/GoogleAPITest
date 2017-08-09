<!DOCTYPE html>
<html>
    <head>
        <style>
            #map {height: 400px; width: 400px;}
            h3 {font-family: Tahoma; margin: 0;}
            p {font-family: Tahoma; font-size: 10pt; margin: 0 0 20px 0;}
        </style>
    </head>

    <body>
        <h3>Generate Map with Markers</h3>
        <p>TODO: get toilet data from database/file and feed into function</p>

        <!-- DRAW MAP -->
        <div id="map"></div>

        <script>
            function initMap() {
                // location map will center to
                var centerLocation = {lat:-37.8136, lng:144.9631};

                // toilets to draw on map (to be pulled dynamically)
                var toilets = [{lat: -37.81823386, lng: 144.9669741}, {lat: -37.80981201, lng: 144.9628186}, {lat: -37.81195695, lng: 144.9561421}, {lat: -37.81532739, lng: 144.9668406}];

                // instantiate map inside element with id 'map'
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 14,
                    center: centerLocation
                });

                // iterates through array of toilets and creates markers for each
                for(i = 0; i < toilets.length; i++) {
                    (function() {
                        var infowindow = new google.maps.InfoWindow({
                            // can use standard html code for content, including images, divs, tables, etc.
                            content: "<img src='assets/publictoiletsymbol.png' width='16px' /><p>Hello world!</p>"
                        });

                        var marker = new google.maps.Marker({
                            position: toilets[i],
                            map: map,
                            draggable: false,
                            animation: google.maps.Animation.DROP
                        });
                        marker.addListener('click', function () {
                            infowindow.open(map, marker);
                        });

                        marker.setMap(map);
                    })();
                }
            }
        </script>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxLH5p73-A7s-WSdi3rcBgOF-dNd6KX_8&callback=initMap">
        </script>
    </body>
</html>