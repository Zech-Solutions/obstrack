<div class="pt-1 pb-4" style="background-color: #2c394b;">
    <h2 class="text-center text-light pt-5 mb-5 fw-bold">Home</h2>
</div>
<p style="display: none;" id="locations"><?= json_encode($locations) ?></p>
<div class="col-md-12" id="map" style="height: 500px;width:100%"></div>
<script>
    var locations = JSON.parse($("#locations").html());

    function initMap() {
        // Initialize the map with a temporary center
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: {
                lat: 0,
                lng: 0
            } // Temporary center
        });

        // Try HTML5 geolocation to get the user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Add markers to the map
                    locations.forEach(function(location) {
                        var marker = new google.maps.Marker({
                            position: {
                                lat: location.lat,
                                lng: location.lng
                            },
                            map: map,
                            title: location.title,
                            // label: location.title,
                        });

                        var infowindow = new google.maps.InfoWindow({
                            content: location.content,
                            title: location.title
                        });

                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });
                    });
                    map.setCenter(pos);
                },
                function() {
                    handleLocationError(true, map);
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, map);
        }

        function handleLocationError(browserHasGeolocation, map) {
            var pos = {
                lat: 51.505,
                lng: -0.09
            }; // Default position
            map.setCenter(pos);
            var infoWindow = new google.maps.InfoWindow({
                position: pos,
                map: map,
                content: browserHasGeolocation ?
                    'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.'
            });
        }
    }

    // Async loading of Google Maps API
    function loadScript(src, callback) {
        var script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.defer = true;
        script.onload = callback;
        document.head.appendChild(script);
    }

    loadScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyC232qKEVqI5x0scuj9UGEVUNdB98PiMX0&callback=initMap&loading=async', function() {
        console.log('Google Maps API loaded successfully');
    });
</script>