<!-- Edit User Details Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="narrow-form" action="" method="post">
            <h3 class="form-text">Update User Details</h3>
            <div class="form-text">
                Fill the fields below to update user personal details.
            </div>
            <div class="form-text">
                You can also use this area to change the user rights.
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                               value="<?php echo escape($data['selectedUser']['u_first_name']) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                               value="<?php echo escape($data['selectedUser']['u_last_name']) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="address_first_line">Street Address</label>
                        <input type="text" placeholder="Street and number" name="address_first_line"
                               id="address_first_line"
                               value="<?php echo escape($data['selectedUser']['u_address_1']) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <input type="text" placeholder="Flat, suite, floor etc." name="address_second_line"
                               id="address_second_line"
                               value="<?php echo escape($data['selectedUser']['u_address_2']) ?>" autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode"
                               value="<?php echo escape($data['selectedUser']['u_postcode']) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city"
                               value="<?php echo escape($data['selectedUser']['u_city']) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="permission">Permission</label>
                        <select class="form-field-select" name="permission" id="permission">
                            <?php foreach ($data['userGroups'] as $group) { ?>
                                <option value="<?php echo escape($group['u_group_id']) ?>" <?php
                                if ($group['u_group_id'] === $data['selectedUser']['u_group_id']) {
                                    echo "selected";
                                } ?>><?php echo escape($group['u_group_name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="update">
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons">
                    <a class="template-btn" href="<?php echo ROOT . 'admin-members' ?>">Back to Members Search</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit User Details Form Area Ends -->
