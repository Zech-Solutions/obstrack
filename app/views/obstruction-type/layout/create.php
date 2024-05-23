<section style="margin-top: 80px;" class="row">
    <div class="col-md-3"></div>
    <div class="card mt-4 col-md-6 center">
        <div class="card-header">
            Add New Obstruction Type
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/obstruction-types/store" method="POST" autocomplete="off">
                <div class="form-group">
                    <label for="name">Obstruction Type Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter obstruction type name">
                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary mt-3 btn-block"><span class="fa fa-check"></span> Submit</button>
                    <a href="<?= URL_PUBLIC ?>/obstruction-types" type="button" class="btn btn-secondary mt-3 btn-block"><span class="fa fa-arrow-left"></span> Back</a>
                </div>
            </form>
        </div>
    </div>
</section>