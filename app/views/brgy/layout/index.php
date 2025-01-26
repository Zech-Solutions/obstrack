<section style="margin-top: 80px;">
    <div class="card mt-4">
        <div class="card-header">
            <h5><span class="fas fa-map"></span> Barangays</h5>
        </div>
        <div class="card-body">
            <div class="ml-auto">
                <a href="<?= URL_PUBLIC ?>/brgys/create" class="btn btn-secondary mt-10"> <span class="fa fa-plus"></span> Add</a>
            </div>
            <div class="mt-2 row">
                <?= $badge_success ?>
                <?= $badge_error ?>
            </div>
            <div class="mt-2">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($brgys)) {
                            foreach ($brgys as $count => $row) {
                        ?>
                                <tr>
                                    <td><?= $count + 1 ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td>
                                        <a href="<?= URL_PUBLIC ?>/brgys/<?= $row['brgy_id'] ?>/edit" class="btn btn-sm btn-warning"> <span class="fa fa-edit"></span></a>
                                        <button type="button" onclick="deleteData('<?= $row['brgy_id'] ?>')" class="btn btn-sm btn-danger"> <span class="fa fa-trash"></span></button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3" class="center">No record found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        new DataTable('#example');
    });
    function deleteData(id) {
        $.post(URL_PUBLIC + "/brgys/data/destroy", {
            brgy_id: id
        }, function(data, status) {
            location.reload();
        });
    }
</script>