<!-- Register Form Area Starts -->
<section class="section-padding5 section-padding3">
    <div class="container">
        <form class="wide-form" action="" method="post">
            <h3>Add Member</h3>
            <div class="form-text">
                Please provide following details to register new user:
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo escape(Input::getValue('first_name')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo escape(Input::getValue('last_name')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="address_first_line">Street Address</label>
                        <input type="text" placeholder="Street and number" name="address_first_line" id="address_first_line" value="<?php echo escape(Input::getValue('address_first_line')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <input type="text" placeholder="Flat, suite, floor etc." name="address_second_line" id="address_second_line" value="<?php echo escape(Input::getValue('address_second_line')) ?>" autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" value="<?php echo escape(Input::getValue('postcode')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" value="<?php echo escape(Input::getValue('city')) ?>" required autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?php echo escape(Input::getValue('username')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo escape(Input::getValue('email')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="password">Password</label>
                        <div class="field-hint">Min. 8 characters. Must include number, lowercase and uppercase letter.</div>
                        <input type="password" name="password" id="password" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="password_again">Repeat Password</label>
                        <input type="password" name="password_again" id="password_again" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="permission">Permission</label>
                        <select class="form-field-select" name="permission" id="permission">
                            <?php foreach ($data['userGroups'] as $group) { ?>
                                <option value="<?php echo escape($group['u_group_name']) ?>" <?php
                                if ($group['u_group_id'] === 1) {
                                    echo "selected";
                                } ?>><?php echo escape($group['u_group_name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="add member">
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
<!-- Register Form Area End -->