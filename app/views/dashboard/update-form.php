<!-- Update Details Form Area Starts -->
<section class="section-padding5 section-padding3">
    <div class="container">
        <form class="update-form" action="<?php echo ROOT . "dashboard/edit/"?>" method="post">
            <div class="form-text">
                Please update your personal details:
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo escape($data['user']['u_first_name']);?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo escape($data['user']['u_last_name']);?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="address_first_line">Street Address</label>
                        <input type="text" placeholder="Street and number" name="address_first_line" id="address_first_line" value="<?php echo escape($data['user']['u_address_1']);?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <input type="text" placeholder="Flat, suite, floor etc." name="address_second_line" id="address_second_line" value="<?php echo escape($data['user']['u_address_2']);?>" autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" value="<?php echo escape($data['user']['u_postcode']);?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" value="<?php echo escape($data['user']['u_city']);?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?php echo escape($data['user']['u_username']);?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo escape($data['user']['u_email']);?>" required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                <input type="submit" class="template-btn" value="update">
            </div>
        </form>
    </div>
</section>
<!-- Update Details Form Area Ends -->
