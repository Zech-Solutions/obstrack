<section style="margin-top: 100px;">
    <div class="row">
        <div class="btn-group">
            <button class="btn btn-outline-primary" onclick="printDiv()">
                <span class="fas fa-print"></span> Print Report
            </button>
        </div>
    </div>
    <div id="printSection">
        <div class="text-center">
            <img src="<?= URL_PUBLIC ?>/images/login.png" alt="" height="100px">
        </div>
        <h5 class="p-2 text-center">
            Obstructions (<?= ucfirst(strtolower($filter)) ?>)
        </h5>
        <table id="example" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Reported By</th>
                    <th>Brgy</th>
                    <th>Street</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($obstructions as $count => $row) { ?>
                    <tr>
                        <td><?= ++$count ?></td>
                        <td><?= date("F d, Y", strtotime($row['created_at'])) ?></td>
                        <td><?= $row['is_anonymous'] ? "Anonymous" : $row['user']['first_name'] ?></td>
                        <td><?= $row['brgy']['name'] ?? "" ?></td>
                        <td><?= $row['street'] ?></td>
                        <td><?= labelStatus($row['status']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<script>
    $(document).ready(function() {
        // new DataTable('#example');
    });

    function printDiv() {
        var divContents = document.getElementById("printSection").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = divContents; // Replace body with div content
        window.print();
        document.body.innerHTML = originalContents; // Restore original content
        location.reload(); // Refresh page to restore event listeners
    }
</script>