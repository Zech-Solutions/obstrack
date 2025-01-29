<section style="margin-top: 80px;">
    <div class="card mt-4 mb-2">
        <div class="card-header">
            <h5><span class="fas fa-edit"></span> Update Staff Information</h5>
        </div>
        <div class="card-body">
            <form action="<?= URL_PUBLIC ?>/users/<?= $user['user_id'] ?>/update" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <label for="profile-image-upload" class="d-block mb-2">
                            <img
                                id="profile-image-preview"
                                src="<?= URL_PUBLIC ?>/images/users/<?= $user['image'] ?>"
                                alt="Profile Image"
                                class="img-thumbnail w-75" />
                        </label>
                        <input
                            type="file"
                            id="profile-image-upload"
                            accept="image/*"
                            class="d-none"
                            name="image"
                            onchange="previewProfileImage(event)" />
                        <button type="button" class="btn btn-secondary mt-2" onclick="document.getElementById('profile-image-upload').click()">
                            <span class="fas fa-upload"></span> Change Image
                        </button>
                    </div>
                    <div class="col-md-8">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="signup-firstname">First Name</label>
                                <input type="text" class="form-control" id="signup-firstname" placeholder="Enter first name" name="first_name"
                                    value="<?= $user['first_name'] ?>"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="signup-middlename">Middle Name</label>
                                <input type="text" class="form-control" id="signup-middlename" placeholder="Enter middle name" name="middle_name"
                                    value="<?= $user['middle_name'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="signup-lastname">Last Name</label>
                                <input type="text" class="form-control" id="signup-lastname" placeholder="Enter last name" name="last_name" value="<?= $user['last_name'] ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="signup-birthdate">Birthdate</label>
                                <input type="date" class="form-control" id="signup-birthdate" name="dob" max="<?= date('Y-m-d') ?>" value="<?= $user['dob'] ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="signup-gender">Gender</label>
                                <select class="form-control" id="signup-gender" name="gender" required>
                                    <option value="" disabled selected>Select gender</option>
                                    <option value="M" <?= $user['gender'] == 'M' ? 'selected' : ''; ?>>Male</option>
                                    <option value="F" <?= $user['gender'] == 'F' ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="signup-birthdate">Email</label>
                                <input type="email" class="form-control" id="signup-birthdate" name="email" value="<?= $user['email'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="signup-address">Address</label>
                            <textarea class="form-control" id="signup-address" placeholder="Enter address" rows="2" name="address" required><?= $user['address'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <?= $badge_error ?>
                            <?= $badge_success ?>
                        </div>
                        <button type="submit" class="btn btn-primary"><span class="fas fa-check"></span> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Preview image before uploading
    function previewProfileImage(event) {
        const input = event.target;
        const preview = document.getElementById("profile-image-preview");
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>