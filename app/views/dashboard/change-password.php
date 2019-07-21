<!-- Change Password Area Starts-->
<section class="section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="form-text">Change Password</h3>
                <form class="narrow-form" action="<?php echo ROOT . "dashboard/changepass" ?>" method="post">
                    <div class="form-text">
                        Please provide your current and new password:
                    </div>
                    <div class="form-field">
                        <label for="old_password">Current Password</label>
                        <input type="password" name="password_current" id="password_current" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="password">New Password</label>
                        <div class="field-hint">Min. 8 characters. Must include number, lowercase and uppercase letter.</div>
                        <input type="password" name="password" id="password" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="password_again">Repeat New Password</label>
                        <input type="password" name="password_again" id="password_again" required autocomplete="off">
                    </div>
                    <div class="login-button">
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        <input type="submit" class="template-btn" value="update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Change Password Area Ends-->