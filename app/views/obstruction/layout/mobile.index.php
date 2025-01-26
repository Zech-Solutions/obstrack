<div class="pt-1 pb-4" style="background-color: #2c394b;">
    <h2 class="text-center text-light pt-5 fw-bold">Obstructions</h2>

    <div class="form-group col-12 p-2">
        <label for="filter_by" class="text-white">Filter by Status</label>
        <select class="form-control" name="filter_by" id="filter_by" onchange="changeFilterStatus(this)">
            <option value="">ALL</option>
            <option value="PENDING">PENDING</option>
            <option value="VERIFIED">VERIFIED</option>
            <option value="REJECTED">REJECTED</option>
            <option value="WIP">IN PROGRESS</option>
            <option value="COMPLETED">RESOLVED</option>
        </select>
    </div>
</div>
<section class="p-3" style="padding-bottom: 100px !important;">
    <?php
    foreach ($obstructions as $row) {
        $images = json_decode($row['images']);
        $status_badge = "";
        if ($row['status'] == 'COMPLETED') {
            $status_badge = '<span class="badge badge-success">Resolved</span>';
        } else if ($row['status'] == 'VERIFIED') {
            $status_badge = '<span class="badge badge-success">Verified</span>';
        } else if ($row['status'] == 'WIP') {
            $status_badge = '<span class="badge badge-warning">In Progress</span>';
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
        <div class="card mt-2 mb-2 card-obstructions obstruction-<?= $row['status'] ?>">
            <div class="card-header d-flex align-items-center">
                <img class="user-img rounded-circle" src="<?= URL_PUBLIC ?>/images/users/default.png" width="50" height="50">
                <div class="ml-3">
                    <h6><?= $row['is_anonymous'] ? "Anonymous" : $row['user']['first_name'] ?></h6>
                    <small><?= timeAgo($row['created_at']) ?></small>
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
                <!-- <p class="card-text">
                    <strong><span class="fas fa-road"></span></strong>
                    <? //= $row['obstruction_type']['name'] 
                    ?>
                </p> -->
                <p class="card-text">
                    <?= $row['detail'] ?><br>
                    <strong>
                        <span class="fas fa-map-marker"></span>
                    </strong>
                    <?= $row['street'] ?>, <?= $row['brgy']['name'] ?><br>
                    <i><?= $row['landmarks'] ?></i>
                </p>
                <div class="rb-container">
                    <h6>Timeline</h6>
                    <ul class="rb">
                        <li class="rb-item" ng-repeat="itembx">
                            <div class="timestamp">
                                <?= date("F d, y h:i A", strtotime($row['created_at'])) ?>
                            </div>
                            <div class="item-title">Citizen reported an obstruction.<br>
                                <?php
                                foreach ($images as $count => $image) {
                                ?>
                                    <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"></image>
                                <?php } ?>
                            </div>
                        </li>

                        <?php
                        foreach ($row['actions'] as $action) {
                            $images = json_decode($action['images']);
                            $itemTitle = $action['detail'];
                            if ($action['status'] == 'VERIFIED') {
                                $itemTitle = "Reported obstruction was verified upon inspection. And given a notice for compliance until " . date('F j, Y', strtotime($action['notice_at'])) . ".";
                            }

                            if ($action['status'] == 'REJECTED') {
                                $itemTitle = "Upon verification, the reported obstruction was found to be non-legitimate and does not constitute a violation. No further actions are required at this time.";
                            }
                        ?>

                            <li class="rb-item" ng-repeat="itembx">
                                <div class="timestamp">
                                    <?= date("F d, y h:i A", strtotime($action['created_at'])) ?>
                                </div>
                                <div class="item-title">
                                    <?=$action['status']?><br>
                                    <?= $itemTitle ?><br>
                                    <?php
                                    foreach ($images as $count => $image) {
                                    ?>
                                        <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"></image>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- <div class="card-footer">
                <button class="btn btn-block-secondary">
                    <span class="fas fa-comment"></span> Comment (1)
                </button>
            </div> -->
        </div>
    <?php } ?>
</section>
<script>
    function changeFilterStatus(el) {
        if (el.value != '') {
            $(".card-obstructions").show();
        } {
            $(".card-obstructions").hide();
            $(".obstruction-" + el.value).show();
        }
    }
</script>

<style>
    .preview-image {
        object-fit: cover;
        width: 50px;
        height: 50px;
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


    .rightbox {
        padding: 0em 34rem 0em 0em;
        height: 100%;
    }

    .rb-container {
        font-family: "PT Sans", sans-serif;
        margin: auto;
        display: block;
        position: relative;
    }

    .rb-container ul.rb {
        padding: 0;
        display: inline-block;
    }

    .rb-container ul.rb li {
        list-style: none;
        margin: auto;
        min-height: 50px;
        border-left: 1px dashed #000000;
        padding: 0 0 8px 20px;
        position: relative;
    }

    .rb-container ul.rb li:last-child {
        border-left: 0;
    }

    .rb-container ul.rb li::before {
        position: absolute;
        left: -10px;
        top: -5px;
        content: " ";
        border: 8px solid rgba(255, 255, 255, 1);
        border-radius: 500%;
        background: #50d890;
        height: 20px;
        width: 20px;
        transition: all 500ms ease-in-out;
    }

    .rb-container ul.rb li:hover::before {
        border-color: #232931;
        transition: all 1000ms ease-in-out;
    }

    ul.rb li .timestamp {
        color: #50d890;
        position: relative;
        /* width: 100px; */
        font-size: 12px;
    }
</style>