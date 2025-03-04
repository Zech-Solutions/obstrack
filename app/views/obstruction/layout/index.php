<section style="margin-top: 80px;">
    <h2 class="mb-4">Obstructions</h2>
    <?php if ($_SESSION[SYSTEM]['role'] == 'USER') { ?>
        <a href="<?= URL_PUBLIC ?>/obstructions/create" class="btn btn-secondary report-btn"><i class="fas fa-plus"></i> Report</a>
    <?php } ?>

    <?php if (count($obstructions) > 0) { ?>
        <?php
        foreach ($obstructions as $row) {
            $images = json_decode($row['images']);
            $actions = $row['actions'];
            usort($actions, function ($a, $b) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            });
        ?>
            <div class="card mt-2 mb-2">
                <div class="card-header d-flex align-items-center">
                    <img class="user-img rounded-circle" src="<?= URL_PUBLIC ?>/images/users/<?= $row['is_anonymous'] ? 'default.png' : $row['user']['image'] ?>" width="50" height="50">
                    <div class="ml-3">
                        <h4><?= $row['is_anonymous'] ? "Anonymous" : $row['user']['first_name'] ?></h4>
                        <span><?= timeAgo($row['created_at']) ?></span>
                        <?= badgeStatus($row['status']) ?>
                    </div>
                    <?php if (in_array($row['status'], ['VERIFIED', 'WIP'])  && in_array($_SESSION[SYSTEM]['role'], ['ADMIN', 'DILG'])) { ?>
                        <div class="ml-auto">
                            <a href="<?= URL_PUBLIC ?>/obstructions/<?= $row['obstruction_id'] ?>/action" class="btn btn-secondary btn-sm"><span class="fas fa-camera"></span> Take Action</a>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION[SYSTEM]['role'] == 'ADMIN' && $row['status'] == 'PENDING') { ?>
                        <div class="ml-auto">
                            <a href="<?= URL_PUBLIC ?>/obstructions/<?= $row['obstruction_id'] ?>/to-verify" class="btn btn-secondary btn-sm"><span class="fas fa-check"></span> Verify Report</a>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <?= $row['detail'] ?><br>
                        <strong>Location</strong>: <?= $row['street'] . ", " . $row['brgy']['name'] ?> <br>
                    </p>
                    <div class="rb-container">
                        <h6>Timeline</h6>
                        <ul class="rb">
                            <li class="rb-item" ng-repeat="itembx">
                                <div class="timestamp">
                                    <?= date("F d, y h:i A", strtotime($row['created_at'])) ?>
                                </div>
                                <div><?= badgeStatus('PENDING') ?></div>
                                <div class="item-title">Citizen reported an obstruction.<br>
                                    <?php
                                    foreach ($images as $count => $image) {
                                    ?>
                                        <?php if (substr($image, 0, 3) == 'vid') { ?>
                                            <video class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>" controls />
                                        <?php } else { ?>
                                            <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>" />
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </li>
                            <?php
                            foreach ($actions as $action) {
                                $actionImages = json_decode($action['images']);
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
                                        <?= badgeStatus($action['status']) ?><br>
                                        <?= $itemTitle ?><br>
                                        <?php
                                        foreach ($actionImages as $count => $image) {
                                        ?>
                                            <image class="preview-image" src="<?= URL_PUBLIC . '/images/obstructions/' . $image ?>"></image>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php } else { ?>
        <div class="no-data-container">
            <i class="fas fa-database no-data-icon"></i> <!-- Using FontAwesome icon -->
            <div class="no-data-text">No Data Available</div>
            <div class="no-data-subtext">Oops! It looks like there's nothing here.</div>
            <a href="javascript:location.reload();" class="refresh-button">Refresh Page</a>
        </div>
    <?php } ?>
</section>

<style>
    .preview-image {
        object-fit: cover;
        width: 200px;
        /* height: 100px; */
        margin-right: 5px;
        margin-bottom: 5px;
        margin: auto;
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
<style>
    .no-data-container {
        text-align: center;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        /* max-width: 400px; */
    }

    .no-data-icon {
        font-size: 50px;
        color: #888;
        margin-bottom: 15px;
    }

    .no-data-text {
        font-size: 20px;
        font-weight: bold;
        color: #555;
        margin-bottom: 10px;
    }

    .no-data-subtext {
        font-size: 14px;
        color: #777;
        margin-bottom: 15px;
    }

    .refresh-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        font-size: 14px;
        font-weight: bold;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
    }

    .refresh-button:hover {
        background-color: #0056b3;
    }
</style>