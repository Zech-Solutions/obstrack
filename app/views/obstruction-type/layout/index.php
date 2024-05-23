<section style="margin-top: 80px;">
    <div class="card mt-4">
        <div class="card-header">
            <h5><span class="fas fa-road"></span> Obstruction Types</h5>
        </div>
        <div class="card-body">
            <div class="ml-auto">
                <a href="<?= URL_PUBLIC ?>/obstruction-types/create" class="btn btn-secondary mt-10"> <span class="fa fa-plus"></span> Add</a>
            </div>
            <div class="mt-2 row">
                <?= $badge_success ?>
                <?= $badge_error ?>
            </div>
            <div class="mt-2">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($obstruction_types)) {
                            foreach ($obstruction_types as $count => $row) {
                        ?>
                                <tr>
                                    <td><?=$count+1?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td>
                                        <a href="<?= URL_PUBLIC ?>/obstruction-types/<?=$row['obstruction_type_id']?>/edit" class="btn btn-sm btn-warning"> <span class="fa fa-edit"></span></a>
                                        <a href="#" class="btn btn-sm btn-danger"> <span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>