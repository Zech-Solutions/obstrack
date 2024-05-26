<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Users</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
    <div class="card mt-4">
        <div class="card-header">
            <h5><span class="fas fa-road"></span> Users</h5>
        </div>
        <div class="card-body">
            <div class="ml-auto">
                <a href="<?= URL_PUBLIC ?>/users/create" class="btn btn-secondary mt-10"> <span class="fa fa-plus"></span> Add</a>
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
                            <th>Role</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($users)) {
                            foreach ($users as $count => $row) {
                        ?>
                                <tr>
                                    <td><?= $count + 1 ?></td>
                                    <td><?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
                                    <td><?= $row['role'] ?></td>
                                    <td><?= $row['dob'] ?></td>
                                    <td><?= $row['gender'] == 'F' ? "Female" : "Male" ?></td>
                                    <!-- <td>
                                        <a href="<?= URL_PUBLIC ?>/users/<?= $row['user_id'] ?>/edit" class="btn btn-sm btn-warning"> <span class="fa fa-edit"></span></a>
                                        <a href="#" class="btn btn-sm btn-danger"> <span class="fa fa-trash"></span></a>
                                    </td> -->
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