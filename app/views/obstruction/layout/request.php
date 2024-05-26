<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= URL_PUBLIC ?>/obstructions">Obstruction</a></li>
            <li class="breadcrumb-item active" aria-current="page">Request Permission</li>
        </ol>
    </nav>
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h5>
                <?php if (isset($request['request_id'])) { ?>
                    <?php if ($request['status'] == 'APPROVED') { ?>
                        <div class="alert alert-success row"><span class="fas fa-thumbs-up"></span> &nbsp; Request Approved</div>
                    <?php } else if ($request['status'] == 'REJECTED') { ?>
                        <div class="alert alert-danger row"><span class="fas fa-thumbs-down"></span> &nbsp; Request Rejected</div>
                    <?php } else { ?>
                        <span class="fas fa-exclamation"></span> Waiting for Road Clearing Permission
                    <?php } ?>
                <?php } else { ?>
                    <span class="fas fa-file"></span> Request Permission for Road Clearing
                <?php } ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (isset($request['request_id'])) {
                $files = json_decode($request['files']);
                $obstructionImages = json_decode($obstruction['images']);
            ?>
                <div class="form-group">
                    <label for="report-address">Message</label>
                    <textarea readonly class="form-control" id="report-address" placeholder="Enter address" rows="2" name="message" required><?= $request['message'] ?></textarea>
                </div>
                <div id="imagePreview" class="mt-2"></div>

                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="before-tab" data-toggle="tab" href="#before" role="tab" aria-controls="before" aria-selected="true"><span class="fas fa-file"> </span> ATTACHMENTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="obs-tab" data-toggle="tab" href="#obs" role="tab" aria-controls="obs" aria-selected="true"><span class="fas fa-road"> </span> Obstruction</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="before" role="tabpanel" aria-labelledby="before-tab">
                        <div class="p-2">
                            <?php
                            foreach ($files as $count => $image) {
                            ?>
                                <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"></image>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="obs" role="tabpanel" aria-labelledby="obs-tab">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="image-gallery">
                                        <img src="<?= URL_PUBLIC . '/images/users/default.png' ?>" class="mr-3 img-thumbnail" alt="Report Image" width="50" height="50">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0"><?= $obstruction['is_anonymous'] ? "Anonymous" : $obstruction['user']['first_name'] . " " . $obstruction['user']['last_name']; ?></h5>
                                        <h5 class="mt-0"><?php echo $obstruction['detail']; ?></h5>
                                        <p><?php echo date("M d, Y h:i A", strtotime($obstruction['created_at'])); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="image-gallery">
                                        <?php foreach ($obstructionImages as $image) : ?>
                                            <img src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>" class="mr-3 img-thumbnail" alt="Report Image" width="80" height="80">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if ($request['status'] == 'PENDING' && $_SESSION[SYSTEM]['role'] == 'DILG') { ?>
                    <button type="button" onclick="respondRequest('<?= $request['obstruction_id'] ?>','<?= $request['request_id'] ?>','APPROVED')" class="btn btn-success mt-3"><span class="fas fa-thumbs-up"></span> Approve</button>
                    <button type="button" onclick="respondRequest('<?= $request['obstruction_id'] ?>','<?= $request['request_id'] ?>','REJECTED')" class="btn btn-danger mt-3"><span class="fas fa-thumbs-down"></span> Reject</button>
                <?php } ?>
            <?php } else { ?>

                <form action="<?= URL_PUBLIC ?>/obstructions/request/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="obstruction_id" value="<?= $obstruction['obstruction_id'] ?>">
                    <div class="form-group">
                        <label for="report-address">Message</label>
                        <textarea class="form-control" id="report-address" placeholder="Enter address" rows="2" name="message" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="images">Select Images</label>
                        <input type="file" class="form-control-file" id="images" accept="image/*" multiple onchange="previewImages()" name="images[]" required>
                    </div>
                    <div id="imagePreview" class="mt-2"></div>
                    <button type="submit" class="btn btn-secondary mt-3"><span class="fas fa-file"></span> Request Now</button>
                </form>
            <?php } ?>
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

    function respondRequest(obstruction_id, request_id, status) {
        $.post(URL_PUBLIC + "/obstructions/request/update", {
            obstruction_id: obstruction_id,
            request_id: request_id,
            status: status
        }, function(data, status) {
            location.reload();
        });
    }
</script>