<!-- Dashboard Area Starts Here -->
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <section class="section-padding5">
                <h3>Your Details</h3>
                <ul class="user-details">
                    <li>First Name:</li>
                    <li><?php echo escape($data['user']['u_first_name']); ?></li>
                    <li>Last Name:</li>
                    <li><?php echo escape($data['user']['u_last_name']); ?></li>
                    <li>Address:</li>
                    <li><?php echo escape($data['user']['u_address_1']); ?></li>
                    <?php if (isset($data['user']['u_address_2'])) { ?>
                        <li></li>
                        <li><?php echo escape($data['user']['u_address_2']); ?></li>
                    <?php } ?>
                    <li>Postcode:</li>
                    <li><?php echo escape($data['user']['u_postcode']); ?></li>
                    <li>City:</li>
                    <li><?php echo escape($data['user']['u_city']); ?></li>
                    <li>Username:</li>
                    <li><?php echo escape($data['user']['u_username']); ?></li>
                    <li>Email:</li>
                    <li><?php echo escape($data['user']['u_email']); ?></li>
                </ul>
                <div class="dashboard-buttons-wrapper">
                    <div class="dashboard-button">
                        <a class="template-btn" href="<?php echo ROOT . 'dashboard/edit/'?>">Edit</a>
                    </div>
                    <div class="dashboard-button">
                        <a class="template-btn" href="<?php echo ROOT . 'dashboard/changepass/'?>">Change Password</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="section-padding5">
                <h3>Your Membership</h3>
                <div>Your membership has expired. Please renew it under link below.</div>
                <div class="dashboard-button">
                    <a class="template-btn" href="#">Renew</a>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <section class="section-padding4">
                <h3>Upcoming Classes</h3>
                <div>
                    Classes
                </div>
            </section>
        </div>
    </div>
</div>
<!-- Dashboard Area Ends Here -->

