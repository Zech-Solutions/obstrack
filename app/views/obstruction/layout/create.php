<section style="margin-top: 80px;">

    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h5>
                <span class="fas fa-camera"></span> Report an Obstruction
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/obstructions/store" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="obstruction_type">Obstruction Type</label>
                    <select class="form-control" id="obstruction_type" name="obstruction_type_id">
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
                    <label for="report-address">Details</label>
                    <textarea class="form-control" id="report-address" placeholder="Enter address" rows="2" name="detail"></textarea>
                </div>
                <div class="form-group">
                    <label for="images">Select Images</label>
                    <input type="file" class="form-control-file" id="images" accept="image/*" multiple onchange="previewImages()" name="images[]">
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