<!-- Edit Membership Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="narrow-form" action="" method="post">
            <h3 class="form-text">Update Membership</h3>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="user-details-admin-panel">
                        <li>First Name:</li>
                        <li><?php echo escape($data['selectedUser']['u_first_name']) ?></li>
                        <li>Last Name:</li>
                        <li><?php echo escape($data['selectedUser']['u_last_name']) ?></li>
                        <li>Address:</li>
                        <li><?php echo escape($data['selectedUser']['u_address_1']) ?></li>
                        <?php if (isset($data['selectedUser']['u_address_2'])) { ?>
                            <li></li>
                            <li><?php echo escape($data['selectedUser']['u_address_2']) ?></li>
                        <?php } ?>
                        <li>Postcode:</li>
                        <li><?php echo escape($data['selectedUser']['u_postcode']) ?></li>
                        <li>City:</li>
                        <li><?php echo escape($data['selectedUser']['u_city']) ?></li>
                        <li>Username:</li>
                        <li><?php echo escape($data['selectedUser']['u_username']) ?></li>
                        <li>Email:</li>
                        <li><?php echo escape($data['selectedUser']['u_email']) ?></li>
                    </ul>
                    <div class="form-field">
                        <label for="date">Expiry Date:</label>
                        <input type="date" name="date" id="date" value="<?php
                            if(isset($data['expiryDate'])) {
                                echo escape($data['expiryDate']);
                            } else{
                                echo date('Y-m-d');
                            }?>" required autocomplete="off">
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
                    <a class="template-btn" href="<?php echo ROOT . 'admin-membership' ?>">Back to Membership Search</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Membership Ends -->