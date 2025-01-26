<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= URL_PUBLIC ?>/obstructions">Obstruction</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verify Report</li>
        </ol>
    </nav>
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h5>
                <span class="fas fa-check"></span> Verify report if its legit or not.
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/obstructions/action/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="obstruction_id" value="<?= $obstruction['obstruction_id'] ?>">
                <div class="row">
                    <div class="col-md-4">
                        <p class="card-text">
                            Detail: <?= $obstruction['detail'] ?><br>
                            Location: <?= $obstruction['street'] ?>, <?= $obstruction['brgy']['name'] ?><br>
                            Landmark: <?= $obstruction['landmarks'] ?>
                        </p>
                        <div>
                            <p>Attachments</p>
                            <?php
                            foreach ($images as $count => $image) {
                            ?>
                                <?php if(substr($image, 0, 3) == 'vid'){ ?>
                                        <video class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>" controls />
                                    <?php }else{ ?>
                                        <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"/>
                                    <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="obstruction_status">Verification Status</label>
                            <select class="form-control" id="obstruction_status" name="status" onchange="changeStatus()" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="VERIFIED">Verified</option>
                                <option value="REJECTED">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group" id="notice-form-group" style="display: none;">
                            <label for="notice_at">Notice Date</label>
                            <input class="form-control" id="notice_at" name="notice_at" type="date" min=<?= date('Y-m-d', strtotime("+5 days")) ?>></input>
                        </div>
                        <div class="form-group">
                            <label for="report-address">Action Taken</label>
                            <textarea class="form-control" id="report-address" placeholder="Enter Action Taken" rows="2" name="detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="images">Select Images</label>
                            <input type="file" class="form-control-file" id="images" accept="image/*" multiple onchange="previewImages()" name="images[]" required>
                        </div>
                        <div id="imagePreview" class="mt-2"></div>
                        <button type="submit" class="btn btn-primary mt-3"><span class="fas fa-file"></span> Submit Verification</button>
                    </div>
                </div>
                <input type="hidden" value="<?=$obstruction['brgy_id']?>" name="brgy_id">
                <input type="hidden" value="<?=$obstruction['reported_by']?>" name="reported_by">
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

    function changeStatus() {
        var obstruction_status = $("#obstruction_status").val();
        if (obstruction_status == 'VERIFIED') {

            $("#notice-form-group").fadeIn();
            $("#notice_at").prop("required", true);
        } else {
            $("#notice-form-group").fadeOut();
            $("#notice_at").prop("required", false);
        }
    }
</script>