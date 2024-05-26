<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Barangay</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    <div class="card mt-4">
        <div class="card-header">
            Add New Barangay
        </div>
        <div class="card-body row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="<?= URL_PUBLIC ?>/brgys/store" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="name">Barangay Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter barangay name">
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-primary mt-3 btn-block"><span class="fa fa-check"></span> Submit</button>
                        <a href="<?= URL_PUBLIC ?>/brgys" type="button" class="btn btn-secondary mt-3 btn-block"><span class="fa fa-arrow-left"></span> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>