<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Requests</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
    <div class="card mt-4">
        <div class="card-header">
            <h5><span class="fas fa-map"></span> Requests</h5>
        </div>
        <div class="card-body">
            <div class="mt-2 row">
                <?= $badge_success ?>
                <?= $badge_error ?>
            </div>
            <div class="mt-2">
                <table class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brgy</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($requests)) {
                            foreach ($requests as $count => $row) {
                        ?>
                                <tr>
                                    <td><?= $count + 1 ?></td>
                                    <td><?= $row['brgy']['name'] ?></td>
                                    <td><?= $row['message'] ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td><?= $row['status'] ?></td>
                                    <td>
                                        <a href="<?= URL_PUBLIC ?>/obstructions/<?= $row['obstruction_id'] ?>/request" class="btn btn-sm btn-warning"> <span class="fa fa-eye"></span> View Request</a>
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
    function deleteData(id) {
        $.post(URL_PUBLIC + "/brgys/data/destroy", {
            brgy_id: id
        }, function(data, status) {
            location.reload();
        });
    }
</script>