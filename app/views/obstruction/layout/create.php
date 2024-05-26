<section style="margin-top: 80px;">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Obstruction</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
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

                <div class="form-group">
                    <label for="obstruction_type">Obstruction Type</label>
                    <select class="form-control" id="obstruction_type" name="obstruction_type_id" required>
                        <option value="" disabled selected>Select Type</option>
                        <?php
                        foreach ($obstruction_types as $obstruction_type) {
                        ?>
                            <option value="<?= $obstruction_type['obstruction_type_id'] ?>"><?= $obstruction_type['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

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
                    <label for="report-address">Details</label>
                    <textarea class="form-control" id="report-address" placeholder="Enter address" rows="2" name="detail" required></textarea>
                </div>
                <div class="form-group">
                    <label for="images">Select Images</label>
                    <input type="file" class="form-control-file" id="images" accept="image/*" multiple onchange="previewImages()" name="images[]" required>
                </div>
                <div id="imagePreview" class="mt-2"></div>
                <button type="submit" class="btn btn-secondary mt-3"><span class="fas fa-file"></span> Report Now</button>
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
    getLocation();

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