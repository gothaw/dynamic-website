<!-- Update Details Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="narrow-form" action="<?php echo ROOT . "dashboard/edit" ?>" method="post">
            <h3 class="form-text">Personal Details</h3>
            <div class="form-text">
                Please update your personal details:
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                               value="<?php echo escape($data['user']['u_first_name']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                               value="<?php echo escape($data['user']['u_last_name']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="address_first_line">Street Address</label>
                        <input type="text" placeholder="Street and number" name="address_first_line"
                               id="address_first_line" value="<?php echo escape($data['user']['u_address_1']) ?>"
                               required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <input type="text" placeholder="Flat, suite, floor etc." name="address_second_line"
                               id="address_second_line" value="<?php echo escape($data['user']['u_address_2']) ?>"
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode"
                               value="<?php echo escape($data['user']['u_postcode']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" value="<?php echo escape($data['user']['u_city']) ?>"
                               required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="update">
            </div>
        </form>
    </div>
</section>
<!-- Update Details Form Area Ends -->
