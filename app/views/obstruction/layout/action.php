<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= URL_PUBLIC ?>/obstructions">Obstruction</a></li>
            <li class="breadcrumb-item active" aria-current="page">Action</li>
        </ol>
    </nav>
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h5>
                <span class="fas fa-camera"></span> Take Action in Obstruction
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/obstructions/action/store" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="obstruction_id" value="<?=$obstruction['obstruction_id']?>">
                <div class="form-group">
                    <label for="obstruction_status">Obstruction Status</label>
                    <select class="form-control" id="obstruction_status" name="status" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="WIP">Work in Progress</option>
                        <option value="COMPLETED">Resolved</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="report-address">Action Taken</label>
                    <textarea class="form-control" id="report-address" placeholder="Action Taken" rows="2" name="detail" required></textarea>
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