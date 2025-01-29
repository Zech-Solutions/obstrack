<section style="margin-top: 80px;">
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
            <span class="fas fa-users"></span>
            <input type="radio" name="options" id="option1" autocomplete="off" checked onclick="handleOptionClick('ALL')"> All
        </label>
        <label class="btn btn-primary">
            <span class="fas fa-city"></span>
            <input type="radio" name="options" id="option2" autocomplete="off" onclick="handleOptionClick('ROOT')"> City Legal Staff
        </label>
        <label class="btn btn-success">
            <span class="fas fa-user"></span>
            <input type="radio" name="options" id="option3" autocomplete="off" onclick="handleOptionClick('ADMIN')"> Brgy Staff
        </label>
    </div>
    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
        <a href="<?= URL_PUBLIC ?>/users/create" class="btn btn-secondary mt-10"> <span class="fa fa-plus"></span> Add New Staff</a>
    </div>
    <div class="row mt-5">
        <?php
        if (count($users)) {
            foreach ($users as $count => $row) {
                if ($row['role'] === 'USER')
                    continue;
        ?>
                <div class="col-md-6 card-staff card-<?= $row['role'] ?>">
                    <div class="card mt-2 mb-2">
                        <div class="card-header d-flex align-items-center">
                            <img class="user-img rounded-circle" src="<?= URL_PUBLIC ?>/images/users/<?= $row['image'] ?>" width="100" height="100">
                            <div class="ml-5">
                                <h6><?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></h6>
                                <span class="badge badge-<?= $row['role'] == 'ROOT' ? "primary" : "success" ?>"><?= $row['role'] == 'ROOT' ? "City Legal Staff" : "Brgy Staff" ?></span><br>
                                <span class="fas fa-envelope"></span> <?= $row['email'] != '' ? $row['email'] : "---" ?><br>
                                <span class="fas fa-map-marker"></span> <?= $row['address'] != '' ? $row['address'] : "---"  ?><br>
                                <span class="fas fa-venus-mars"></span> <?= $row['gender'] == 'M' ? 'Male' : "Female"  ?><br>
                                <span class="fas fa-calendar"></span> <?= !empty($row['dob']) ? date("M d, Y",strtotime($row['dob'])) : "---"  ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-outline-primary" href="<?= URL_PUBLIC ?>/users/<?= $row['user_id'] ?>/edit">
                                <span class="fas fa-edit"></span> Edit
                            </a>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</section>

<script>
    function handleOptionClick(option) {
        $(".card-staff").hide();
        if (option != 'ALL') {
            $(".card-" + option).show();
        } else {
            $(".card-staff").show();
        }
    }
</script>