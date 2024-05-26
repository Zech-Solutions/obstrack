<section style="margin-top: 80px;">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Obstruction</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
    <?php if ($_SESSION[SYSTEM]['role'] == 'USER') { ?>
        <a href="<?= URL_PUBLIC ?>/obstructions/create" class="btn btn-secondary report-btn"><i class="fas fa-plus"></i> Report</a>
    <?php } ?>

    <?php
    foreach ($obstructions as $row) {
        $images = json_decode($row['images']);
        $status_badge = "";
        if ($row['status'] == 'COMPLETED') {
            $status_badge = '<span class="badge badge-success">Resolved</span>';
        } else if ($row['status'] == 'WIP') {
            $status_badge = '<span class="badge badge-warning">Work in Progress</span>';
        } else if ($row['status'] == 'REJECTED') {
            $status_badge = '<span class="badge badge-danger">Rejected</span>';
        } else {
            $status_badge = '<span class="badge badge-danger">Pending</span>';
        }

        usort($row['actions'], function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $wipData = array_filter($row['actions'], function ($item) {
            return $item['status'] === 'WIP';
        });

        $completedData = array_filter($row['actions'], function ($item) {
            return $item['status'] === 'COMPLETED';
        });
    ?>
        <div class="card mt-2 mb-2">
            <div class="card-header d-flex align-items-center">
                <img class="user-img rounded-circle" src="<?= URL_PUBLIC ?>/images/users/default.png" width="50" height="50">
                <div class="ml-3">
                    <h4><?= $row['is_anonymous'] ? "Anonymous" : $row['user']['first_name'] ?></h4>
                    <span><?= date("F d, y h:i A", strtotime($row['created_at'])) ?></span>
                    <?= $status_badge ?>
                </div>
                <?php if (in_array($row['status'], ['PENDING', 'WIP'])  && $_SESSION[SYSTEM]['role'] == 'ADMIN' && $row['approval_status'] == 'APPROVED') { ?>
                    <div class="ml-auto">
                        <a href="<?= URL_PUBLIC ?>/obstructions/<?= $row['obstruction_id'] ?>/action" class="btn btn-secondary btn-sm"><span class="fas fa-camera"></span> Take Action</a>
                    </div>
                <?php } ?>
                <?php if ($_SESSION[SYSTEM]['role'] == 'ADMIN' && $row['approval_status'] == 'PENDING') { ?>
                    <div class="ml-auto">
                        <a href="<?= URL_PUBLIC ?>/obstructions/<?= $row['obstruction_id'] ?>/request" class="btn btn-secondary btn-sm"><span class="fas fa-file"></span> Request Permission</a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <p class="card-text"><?= $row['detail'] ?></p>
                <p class="card-text"><strong><span class="fas fa-road"></span></strong> <?= $row['obstruction_type']['name'] ?></p>
                <p class="card-text"><strong><span class="fas fa-map-marker"></span></strong> <?= $row['brgy']['name'] ?></p>
                <!-- Tabs -->
                <ul class="nav nav-tabs mt-3" id="myTab<?= $row['obstruction_id'] ?>" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="before-tab<?= $row['obstruction_id'] ?>" data-toggle="tab" href="#before<?= $row['obstruction_id'] ?>" role="tab" aria-controls="before" aria-selected="true"><span class="fas fa-camera"> </span> BEFORE</a>
                    </li>
                    <?php if ($row['status'] != 'REJECTED') { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="during-tab<?= $row['obstruction_id'] ?>" data-toggle="tab" href="#during<?= $row['obstruction_id'] ?>" role="tab" aria-controls="during" aria-selected="false"><span class="fas fa-spinner"> </span> WIP <badge class="badge badge-warning"><?= count($wipData) ?? 0 ?></badge> </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="after-tab<?= $row['obstruction_id'] ?>" data-toggle="tab" href="#after<?= $row['obstruction_id'] ?>" role="tab" aria-controls="after" aria-selected="false"><span class="fas fa-check"></span> RESOLVED <badge class="badge badge-success"><?= count($completedData) ?? 0 ?></a>
                        </li>
                    <?php } ?>
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
                    <?php if ($row['status'] != 'REJECTED') { ?>
                        <div class="tab-pane fade" id="during<?= $row['obstruction_id'] ?>" role="tabpanel" aria-labelledby="during-tab<?= $row['obstruction_id'] ?>">
                            <?php
                            if (count($wipData) > 0) {
                            ?>
                                <ul class="list-group">
                                    <?php
                                    foreach ($wipData as $wip) {
                                        $images = json_decode($wip['images']);
                                    ?>
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="image-gallery">
                                                    <?php foreach ($images as $image) : ?>
                                                        <img src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>" class="mr-3 img-thumbnail" alt="Report Image">
                                                    <?php endforeach; ?>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mt-0"><?php echo $wip['detail']; ?></h5>
                                                    <p><?php echo date("M d, Y h:i A", strtotime($wip['created_at'])); ?></p>
                                                    <!-- <p><span class="fas fa-user"></span>: <?php echo $wip['actioned_by']; ?></p> -->
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <ul class="list-group">
                                    <li class="list-group-item text-center text-muted">No actions taken yet.</li>
                                </ul>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="after<?= $row['obstruction_id'] ?>" role="tabpanel" aria-labelledby="after-tab<?= $row['obstruction_id'] ?>">
                            <?php
                            if (count($completedData) > 0) {
                            ?>
                                <ul class="list-group">
                                    <?php
                                    foreach ($completedData as $complete) {
                                        $images = json_decode($complete['images']);
                                    ?>
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="image-gallery">
                                                    <?php foreach ($images as $image) : ?>
                                                        <img src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>" class="mr-3 img-thumbnail" alt="Report Image">
                                                    <?php endforeach; ?>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mt-0"><?php echo $complete['detail']; ?></h5>
                                                    <p><?php echo date("M d, Y h:i A", strtotime($complete['created_at'])); ?></p>
                                                    <!-- <p><span class="fas fa-user"></span>: <?php echo $complete['actioned_by']; ?></p> -->
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <ul class="list-group">
                                    <li class="list-group-item text-center text-muted">No actions taken yet.</li>
                                </ul>
                            <?php
                            }
                            ?>
                        </div>
                    <?php } ?>
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

    .report-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        /* border-radius: 50%; */
        /* padding: 15px 20px; */
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .report-btn i {
        margin-right: 8px;
    }

    .media img {
        max-width: 100px;
        max-height: 100px;
        margin-right: 15px;
    }

    .media-body {
        flex: 2;
    }

    .image-gallery {
        display: flex;
        flex-wrap: wrap;
    }

    .image-gallery img {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>