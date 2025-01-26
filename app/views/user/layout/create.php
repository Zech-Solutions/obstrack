<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= URL_PUBLIC ?>/home"><span class="fas fa-home"></span> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= URL_PUBLIC ?>/users">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    <div class="card mt-4 mb-2">
        <div class="card-header">
            <h5><span class="fas fa-plus"></span> Create new user account</h5>
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/users/store" method="POST" autocomplete="off">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="signup-firstname">First Name</label>
                        <input type="text" class="form-control" id="signup-firstname" placeholder="Enter first name" name="first_name" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="signup-middlename">Middle Name</label>
                        <input type="text" class="form-control" id="signup-middlename" placeholder="Enter middle name" name="middle_name">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="signup-lastname">Last Name</label>
                        <input type="text" class="form-control" id="signup-lastname" placeholder="Enter last name" name="last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="signup-birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="signup-birthdate" name="dob" max="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="signup-gender">Gender</label>
                        <select class="form-control" id="signup-gender" name="gender" required>
                            <option value="" disabled selected>Select gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="signup-category">Category</label>
                        <select class="form-control" id="signup-category" name="role" onchange="changeCategory()" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="ADMIN">Barangay Staff</option>
                            <option value="ROOT">City Legal Staff</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="brgy-form-group" style="display: none;">
                    <label for="signup-brgy">Barangay</label>
                    <select class="form-control" id="signup-brgy" name="brgy_id">
                        <option value="" disabled selected>Select Barangay</option>
                        <?php foreach ($brgys as $brgy) { ?>
                            <option value="<?= $brgy['brgy_id'] ?>"><?= $brgy['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="signup-address">Address</label>
                    <textarea class="form-control" id="signup-address" placeholder="Enter address" rows="2" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="signup-username">Username</label>
                    <input type="text" class="form-control" id="signup-username" placeholder="Enter username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" class="form-control" id="signup-password" placeholder="Password" name="password" required>
                </div>
                <div class="form-group">
                    <?= $badge_error ?>
                    <?= $badge_success ?>
                </div>
                <button type="submit" class="btn btn-primary"><span class="fas fa-check"></span> Submit</button>
            </form>
        </div>
    </div>
</section>
<script>
    function changeCategory() {
        var signup_category = $("#signup-category").val();
        if (signup_category == 'ADMIN') {
            $("#brgy-form-group").fadeIn();
            $("#signup-brgy").prop("required", true);
        } else {
            $("#brgy-form-group").fadeOut();
            $("#signup-brgy").prop("required", false);
        }
    }
</script>