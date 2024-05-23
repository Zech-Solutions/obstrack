<section style="margin-top: 80px;" class="row">
    <div class="col-md-3"></div>
    <div class="card mt-4 col-md-6 center">
        <div class="card-header">
            Edit Obstruction Type
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/obstruction-types/<?=$obstruction_type['obstruction_type_id']?>" method="POST" autocomplete="off">
                <div class="form-group">
                    <label for="name">Obstruction Type Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$obstruction_type['name']?>" placeholder="Enter obstruction type name">
                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary mt-3 btn-block"><span class="fa fa-check"></span> Update</button>
                    <a href="<?= URL_PUBLIC ?>/obstruction-types" type="button" class="btn btn-secondary mt-3 btn-block"><span class="fa fa-arrow-left"></span> Back</a>
                </div>
            </form>
        </div>
    </div>
</section>