<section style="margin-top: 80px;">
    <div class="row">
        <p style="display: none;" id="locations"><?= json_encode($locations) ?></p>
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Total Reports</h3>
                    <p class="card-text display-4">
                        <a href="<?=URL_PUBLIC?>/obstructions/show?filter=all" class="text-white"><?= $report_data['total'] ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-book"></i> Pending Reports</h3>
                    <p class="card-text display-4">
                        <a href="<?=URL_PUBLIC?>/obstructions/show?filter=PENDING" class="text-white"><?= $report_data['pending'] ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-check-circle"></i> Verified Reports</h3>
                    <p class="card-text display-4">
                        <a href="<?=URL_PUBLIC?>/obstructions/show?filter=VERIFIED" class="text-white"><?= $report_data['verified'] ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-times-circle"></i> Rejected Reports</h3>
                    <p class="card-text display-4">
                        <a href="<?=URL_PUBLIC?>/obstructions/show?filter=REJECTED" class="text-white"><?= $report_data['rejected'] ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-exclamation-circle"></i> Inprogress Reports</h3>
                    <p class="card-text display-4">
                        <a href="<?=URL_PUBLIC?>/obstructions/show?filter=WIP" class="text-white"><?= $report_data['wip'] ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-check-circle"></i> Resolved Reports</h3>
                    <p class="card-text display-4">
                        <a href="<?=URL_PUBLIC?>/obstructions/show?filter=COMPLETED" class="text-white"><?= $report_data['completed'] ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="map" style="height: 500px;width:100%"></div>
    </div>
    <!-- <h3>Recent Reports</h3>
    <ul id="reports-list" class="list-group">
    </ul> -->
</section>
<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sample data
        const reports = [{
                id: 1,
                type: 'Pothole',
                status: 'Active'
            },
            {
                id: 2,
                type: 'Fallen Tree',
                status: 'Resolved'
            },
            {
                id: 3,
                type: 'Flooding',
                status: 'Active'
            }
        ];

        // Update statistics
        const totalReports = reports.length;
        const activeObstructions = reports.filter(report => report.status === 'Active').length;
        const resolvedIssues = reports.filter(report => report.status === 'Resolved').length;

        document.getElementById('total-reports').textContent = totalReports;
        document.getElementById('active-obstructions').textContent = activeObstructions;
        document.getElementById('resolved-issues').textContent = resolvedIssues;

        // Update recent reports
        const reportsList = document.getElementById('reports-list');
        reports.forEach(report => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = `${report.type} - ${report.status}`;
            reportsList.appendChild(listItem);
        });
    });
</script> -->
<script>
    var locations = JSON.parse($("#locations").html());

    function initMap() {
        // Initialize the map with a temporary center
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: {
                lat: 10.64358984425083,
                lng: 122.94014836858112
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
                                lat: location.latitude * 1,
                                lng: location.longitude * 1
                            },
                            map: map,
                            title: location.title,
                            label: location.title,
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
                lat: 10.64358984425083,
                lng: 122.94014836858112
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