<section style="margin-top: 80px;">
    <div class="container my-5">
        <h2 class="mb-4">Notifications</h2>
        <?php if (count($notifications) > 0) { ?>
            <div class="list-group">
                <!-- Unread Notification -->
                <?php
                foreach ($notifications as $row) {
                    $icon = $row['is_seen'] ? '' : '🔵';
                ?>
                    <a href="<?= URL_PUBLIC ?>/obstructions/<?= $row['obstruction_id'] ?>?notif_id=<?= $row['notification_id'] ?>" class="list-group-item list-group-item-action d-flex align-items-start bg-light <?= $row['is_seen'] ? "bg-white" : "bg-light" ?>">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><?= $icon ?><b><?= $row['obstruction']['is_anonymous'] ? "Anonymous" : ($row['user_sender']['first_name'] ?? "") ?></b></div>
                            <?= $row['description'] ?>
                            <small class="text-muted d-block mt-1"><?= timeAgo($row['created_at']) ?></small>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="no-data-container">
                <i class="fas fa-database no-data-icon"></i> <!-- Using FontAwesome icon -->
                <div class="no-data-text">No Data Available</div>
                <div class="no-data-subtext">Oops! It looks like there's nothing here.</div>
                <a href="javascript:location.reload();" class="refresh-button">Refresh Page</a>
            </div>
        <?php } ?>
    </div>
</section>
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