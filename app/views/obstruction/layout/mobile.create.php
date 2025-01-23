<div class="pt-1 pb-4" style="background-color: #2c394b;">
    <h2 class="text-center text-light pt-5 mb-5 fw-bold">Report an Obstruction</h2>
</div>
<section class="p-3" style="padding-bottom: 100px !important;">
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h5>
                <span class="fas fa-camera"></span> Report an Obstruction
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/obstructions/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="location" name="location">
                <div class="form-group checkbox">
                    <input type="checkbox" name="is_anonymous" id="report-is-anonymous">
                    <label for="report-is-anonymous">Anonymous Report</label>
                </div>
                <div id="map"></div>
                <div class="form-group">
                    <label for="obstruction_type">Barangay</label>
                    <select class="form-control" id="obstruction_type" name="brgy_id" required>
                        <option value="" disabled selected>Select Barangay</option>
                        <?php
                        foreach ($brgys as $brgy) {
                        ?>
                            <option value="<?= $brgy['brgy_id'] ?>"><?= $brgy['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="report-street">Street</label>
                    <input class="form-control" id="report-street" placeholder="Enter Street name" rows="2" name="street" required>
                </div>
                <div class="form-group">
                    <label for="report-landmarks">Landmarks</label>
                    <textarea class="form-control" id="report-landmarks" placeholder="Enter a near landmark" rows="2" name="landmarks" required></textarea>
                </div>
                <div class="form-group">
                    <label for="report-address">Details</label>
                    <textarea class="form-control" id="report-address" placeholder="Enter address" rows="2" name="detail" required></textarea>
                </div>
                <div class="form-group">
                    <label for="images">Select Images</label>
                    <input type="file" class="form-control-file" id="images" accept="image/*" multiple onchange="previewImages()" name="images[]" required>
                </div>
                <div id="imagePreview" class="mt-2"></div>
                <button type="submit" class="btn btn-primary btn-block mt-3"><span class="fas fa-file"></span> Report Now</button>
            </form>
        </div>
    </div>
</section>

<style>
    .preview-image {
        object-fit: cover;
        width: 100px;
        height: 100px;
        margin-right: 5px;
        margin-bottom: 5px;
        border: 1px solid gray;
    }

    #map {
        height: 70vh;
        /* Adjust the height of the map */
        width: 100%;
        /* Full width */
    }

    #info {
        padding: 10px;
    }
</style>
<script>
    function previewImages() {
        var preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        var files = document.getElementById('images').files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image');
                preview.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    function initMap() {
        const mapElement = document.getElementById("map");

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    }

                    $("#location").val(JSON.stringify(pos));
                    // Initialize the map centered on the user's location
                    const userLocation = {
                        lat,
                        lng
                    };
                    const map = new google.maps.Map(mapElement, {
                        center: userLocation,
                        zoom: 15,
                    });

                    // Add a marker at the user's location
                    new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "You are here!",
                    });

                    // Use the Geocoding API to get barangay name
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        location: userLocation
                    }, (results, status) => {
                        if (status === "OK" && results[0]) {
                            // Find the component for "sublocality_level_1" (usually barangay)
                            const addressComponents = results[0].address_components;
                            console.log(addressComponents);
                            const street = addressComponents.find((component) =>
                                component.types.includes("route")
                            );

                            // Display the barangay name
                            if (street) {
                                $("#report-street").val(street.long_name);
                            }
                        }
                    });
                },
                (error) => {
                    console.error("Geolocation error:", error);
                }
            );
        } else {
            alert("Geolocation is not supported by your browser.");
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

    loadScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyC232qKEVqI5x0scuj9UGEVUNdB98PiMX0&libraries=places&callback=initMap&loading=async', function() {
        console.log('Google Maps API loaded successfully');
    });
</script>
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        console.log(position);
        var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
        }
        $("#location").val(JSON.stringify(pos));
    }
</script>