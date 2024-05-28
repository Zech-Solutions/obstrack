<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Obstruction Type</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
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
                                    <td><?= $count + 1 ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td>
                                        <a href="<?= URL_PUBLIC ?>/obstruction-types/<?= $row['obstruction_type_id'] ?>/edit" class="btn btn-sm btn-warning"> <span class="fa fa-edit"></span></a>
                                        <button href="#" type="button" class="btn btn-sm btn-danger" onclick="deleteItem('<?= $row['obstruction_type_id'] ?>')"> <span class="fa fa-trash"></span></button>
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

<script>
    function deleteItem(id) {
        $.post(URL_PUBLIC + "/obstruction-types/data/destroy", {
            obstruction_type_id: id
        }, function(data, status) {
            location.reload();
        });
    }
</script>