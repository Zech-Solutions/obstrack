<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obstrack</title>
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/css/mobile.style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<body>
    <div class="tab-content d-md-none d-lg-none d-xl-none" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"
            style="background-color: #f0f0f0 !important;">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://images.unsplash.com/photo-1639084695451-c245d35ef106?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.unsplash.com/photo-1639084696349-905e3c1045f9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDF8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.unsplash.com/photo-1639084695940-40546c3262c2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDR8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Halaman Pengenalan atau Intro -->
        <div class="tab-pane fade pt-1 pb-4" id="notes" role="tabpanel" aria-labelledby="notes-tab"
            style="background-color: #2c394b;">
            <h2 class="text-center text-light pt-5 mb-5 fw-bold">Notes</h2>
        </div>

        <!-- Halaman Blog -->
        <div class="tab-pane fade pt-1 pb-4" id="project"
            role="tabpanel" aria-labelledby="project-tab" style="background-color: #2c394b;">
            <h2 class="text-center text-light pt-5 mb-5 fw-bold">Project</h2>
        </div>

        <!-- Halaman Notifikasi -->
        <div class="tab-pane fade pt-1 pb-4" id="collection" role="tabpanel" aria-labelledby="collection-tab" style="background-color: #2c394b;">
            <div class="container-fluid">
                <h2 class="text-center text-light mt-5 mb-2 fw-bold">Collection</h2>
            </div>
            <br>
            <div class="card m-3 border-0 shadow" style="position: absolute;">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                        content.</p>
                </div>
            </div>
            <br>
            <div class="card m-3 border-0 shadow" style="position: absolute; bottom: 220px;">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                        content.</p>
                </div>
            </div>
            <br>
            <div class="card m-3 border-0 shadow" style="position: absolute; bottom: 100px;">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                        content.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none d-md-block d-lg-block d-xl-block">
        <h1>Please open in mobile</h1>
    </div>

    <nav class="navbar navbar-light navbar-expand rounded-pill mb-3 ms-3 me-3 fixed-bottom d-md-none d-lg-none d-xl-none shadow"
        style="background: #0f071f;">
        <ul class="nav nav-justified w-100" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">
                    <span><i class="bi bi-house-fill"></i></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button"
                    role="tab" aria-controls="intro" aria-selected="true">
                    <span><i class="bi bi-journal-album"></i></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">
                    <span><i class="bi bi-geo"></i></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="collection-tab" data-bs-toggle="tab" data-bs-target="#collection" type="button"
                    role="tab" aria-controls="notif" aria-selected="false">
                    <span><i class="bi bi-person"></i></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?= URL_PUBLIC ?>/logout" class="nav-link">
                    <span><i class="bi bi-box-arrow-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>