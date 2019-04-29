<!-- Update Details Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <h3 class="form-text">Renew your Membership</h3>
        <div class="form-text">
            Please provide your details and click the button to process your payment via PayPal.
        </div>
        <form enctype="multipart/form-data" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <INPUT TYPE="hidden" name="address_override" value="1">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="seller@email.com">
            <input type="hidden" name="notify_url" value="sellerwebsite.com/confirmation.php">
            <INPUT TYPE="hidden" name="address_override" value="1">
            <input type="hidden" name="item_name" value="company order">
            <input type="hidden" name="item_number" value="1">
            <input type="hidden" name="currency_code" value="GBP">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo escape($data['user']['u_first_name']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo escape($data['user']['u_last_name']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="address1">Street Address</label>
                        <input type="text" placeholder="Street and number" name="address1" id="address1" value="<?php echo escape($data['user']['u_address_1']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <input type="text" placeholder="Flat, suite, floor etc." name="address2" id="address2" value="<?php echo escape($data['user']['u_address_2']) ?>" autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="zip">Postcode</label>
                        <input type="text" name="zip" id="zip" value="<?php echo escape($data['user']['u_postcode']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" value="<?php echo escape($data['user']['u_city']) ?>" required autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <input type="hidden" name="country" id="country" value="GB" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo escape($data['user']['u_email']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" value="" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="amount-dummy">Membership Fee</label>
                        <input type="text" name="amount-dummy" readonly id="amount-dummy" value="&pound;15.00" required autocomplete="off">
                    </div>
                    <input type="hidden" id="amount" name="amount" value="15.00">
                </div>
            </div>
            <div class="form-button">
                <button type="submit" name="submit" class="template-btn">Renew membership</button>
            </div>
        </form>
    </div>
</section>
<!-- Update Details Form Area Ends -->