<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obstrack</title>
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/css/mobile.style.css">
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/vendor/fontawesome/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="<?= URL_PUBLIC ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= URL_PUBLIC ?>/vendor/bootstrap/bootstrap.min.js"></script>

</head>

<body>
    <div class="tab-content" id="myTabContent">
        <?php require_once $view; ?>
    </div>

    <nav class="navbar navbar-light navbar-expand rounded-pill mb-3 ms-3 me-3 fixed-bottom shadow"
        style="background: #0f071f;">
        <ul class="nav nav-justified w-100" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="<?= URL_PUBLIC ?>" class="nav-link">
                    <span><i class="bi bi-house-fill"></i></span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?= URL_PUBLIC ?>/obstructions" class="nav-link">
                    <span><i class="bi bi-journal-album"></i></span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?= URL_PUBLIC ?>/obstructions/create" class="nav-link">
                    <span><i class="bi bi-geo"></i></span>
                </a>
                <!-- <button class="nav-link" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">
                    <span><i class="bi bi-geo"></i></span>
                </button> -->
            </li>
            <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="collection-tab" data-bs-toggle="tab" data-bs-target="#collection" type="button"
                    role="tab" aria-controls="notif" aria-selected="false">
                    <span><i class="bi bi-person"></i></span>
                </button>
            </li> -->
            <li class="nav-item" role="presentation">
                <a href="<?= URL_PUBLIC ?>/logout" class="nav-link">
                    <span><i class="bi bi-box-arrow-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
</body>

</html>