<section style="margin-top: 80px;">

    <a href="<?= URL_PUBLIC ?>/obstructions/create" class="btn btn-primary btn-lg mt-10" id="loadDataButton">Report</a>

    <?php
    foreach ($obstructions as $row) {
        $images = json_decode($row['images']);
    ?>
        <div class="card mt-2 mb-2">
            <div class="card-header d-flex align-items-center">
                <img class="user-img rounded-circle" src="https://via.placeholder.com/50x50&text=J">
                <div class="ml-3">
                    <h4><?= $row['reported_by'] ?></h4>
                    <span><?= $row['created_at'] ?></span>
                    <badge class="badge badge-success"><?= $row['status'] ?></badge>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text"><?=$row['detail']?></p>
                <p class="card-text"><strong><span class="fas fa-map-marker"></span></strong> sad</p>
                <div>
                    <?php
                    foreach ($images as $count => $image) {
                    ?>
                        <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"></image>
                    <?php } ?>
                </div>
                <a href="#" class="btn btn-primary mt-2">View Report</a>
            </div>
        </div>
    <?php } ?>
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