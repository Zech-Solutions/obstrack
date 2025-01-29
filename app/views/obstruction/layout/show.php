<section style="margin-top: 100px;">
    <h2 class="p-2">
        <span class="fas fa-book"></span>
        Obstructions (<?= ucfirst(strtolower($filter)) ?>)
    </h2>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Reported By</th>
                <th>Brgy</th>
                <th>Street</th>
                <th>Details</th>
                <th>landmark</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($obstructions as $count => $row) { ?>
                <tr>
                    <td><?=++$count?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['is_anonymous'] ? "Anonymous" : $row['user']['first_name'] ?></td>
                    <td><?= $row['brgy']['name'] ?? "" ?></td>
                    <td><?= $row['street'] ?></td>
                    <td><?= $row['detail'] ?></td>
                    <td><?= $row['landmarks'] ?></td>
                    <td><?= badgeStatus($row['status']) ?></td>
                    <td>
                        <a href="<?=URL_PUBLIC?>/obstructions/<?=$row['obstruction_id']?>">
                            <span class="fas fa-eye"></span> View
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
<script>
    $(document).ready(function() {
        new DataTable('#example');
    });
</script>