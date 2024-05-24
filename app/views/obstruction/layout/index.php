<section style="margin-top: 80px;">

    <a href="<?= URL_PUBLIC ?>/obstructions/create" class="btn btn-primary btn-lg mt-10" id="loadDataButton">Report</a>

    <?php
    foreach ($obstructions as $row) {
        $images = json_decode($row['images']);
    ?>
        <div class="card mt-2 mb-2">
            <div class="card-header d-flex align-items-center">
                <img class="user-img rounded-circle" src="https://via.placeholder.com/50x50&text=U">
                <div class="ml-3">
                    <h4><?= $row['is_anonymous'] ? "Anonymous" : $row['user']['first_name'] ?></h4>
                    <span><?= $row['created_at'] ?></span>
                    <span class="badge badge-success"><?= $row['status'] ?></span>
                </div>
                <?php if ($row['status'] != 'COMPLETED' && $_SESSION[SYSTEM]['role'] != 'USER') { ?>
                    <div class="ml-auto">
                        <a href="#" class="btn btn-secondary btn-sm"><span class="fas fa-camera"></span> Take Action</a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <p class="card-text"><?= $row['detail'] ?></p>
                <p class="card-text"><strong><span class="fas fa-map-marker"></span></strong> sad</p>
                <!-- Tabs -->
                <ul class="nav nav-tabs mt-3" id="myTab<?= $row['obstruction_id'] ?>" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="before-tab<?= $row['obstruction_id'] ?>" data-toggle="tab" href="#before<?= $row['obstruction_id'] ?>" role="tab" aria-controls="before" aria-selected="true"><span class="fas fa-camera"> </span> BEFORE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="during-tab<?= $row['obstruction_id'] ?>" data-toggle="tab" href="#during<?= $row['obstruction_id'] ?>" role="tab" aria-controls="during" aria-selected="false"><span class="fas fa-spinner"> </span> WIP </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="after-tab<?= $row['obstruction_id'] ?>" data-toggle="tab" href="#after<?= $row['obstruction_id'] ?>" role="tab" aria-controls="after" aria-selected="false"><span class="fas fa-check"></span> COMPLETED</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent<?= $row['obstruction_id'] ?>">
                    <div class="tab-pane fade show active" id="before<?= $row['obstruction_id'] ?>" role="tabpanel" aria-labelledby="before-tab<?= $row['obstruction_id'] ?>">
                        <div class="p-2">
                            <?php
                            foreach ($images as $count => $image) {
                            ?>
                                <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"></image>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="during<?= $row['obstruction_id'] ?>" role="tabpanel" aria-labelledby="during-tab<?= $row['obstruction_id'] ?>">
                        <p>Content for DURING</p>
                    </div>
                    <div class="tab-pane fade" id="after<?= $row['obstruction_id'] ?>" role="tabpanel" aria-labelledby="after-tab<?= $row['obstruction_id'] ?>">
                        <p>Content for AFTER</p>
                    </div>
                </div>
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