<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/css/style.css">
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/vendor/fontawesome/all.min.css">
    <script>
        const URL_PUBLIC = "<?= URL_PUBLIC ?>";
    </script>
    <script src="<?= URL_PUBLIC ?>/js/main.js" defer></script>
    <style>
        .navbar-custom {
            background-color: #4CAF50;
            /* Change this to your preferred color */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#"><?= SYSTEM_NAME ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL_PUBLIC ?>/home"><span class="fas fa-home"></span> Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDataDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-edit"></span> Manage Data
                    </a>
                    <div class="dropdown-menu" aria-labelledby="manageDataDropdown">
                        <a class="dropdown-item" href="<?= URL_PUBLIC ?>/departments">Departments</a>
                        <a class="dropdown-item" href="<?= URL_PUBLIC ?>/obstruction-types">Obstruction Types</a>
                        <a class="dropdown-item" href="<?= URL_PUBLIC ?>/users">Users</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL_PUBLIC ?>/obstructions"><span class="fas fa-road"></span> Obstructions</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $_SESSION[SYSTEM]['first_name'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="<?= URL_PUBLIC ?>/profile"><span class="fas fa-user"></span> Profile</a>
                        <a class="dropdown-item" href="<?= URL_PUBLIC ?>/logout"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php require_once $view; ?>
    </div>

    <script src="<?= URL_PUBLIC ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= URL_PUBLIC ?>/vendor/popper/popper.min.js"></script>
    <script src="<?= URL_PUBLIC ?>/vendor/bootstrap/bootstrap.min.js"></script>
</body>

</html>