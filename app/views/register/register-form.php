<!-- Register Form Area Starts -->
<section class="section-padding5 section-padding3">
    <div class="container">
        <form class="register-form" action="<?php echo ROOT . "register/form"?>" method="post">
            <div class="register-text">
                Please provide following details to register:
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="register-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo escape(Input::get('first_name'));?>" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo escape(Input::get('last_name'));?>" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <label for="address_first_line">Street Address</label>
                        <input type="text" placeholder="Street and number" name="address_first_line" id="address_first_line" value="<?php echo escape(Input::get('address_first_line'));?>" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <input type="text" placeholder="Flat, suite, floor etc." name="address_second_line" id="address_second_line" value="<?php echo escape(Input::get('address_second_line'));?>" autocomplete="off">
                    </div>
                    <div class="register-field">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" value="<?php echo escape(Input::get('postcode'));?>" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" value="<?php echo escape(Input::get('city'));?>" autocomplete="off"> <!--required-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="register-field">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo escape(Input::get('email'));?>" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <label for="password">Password</label>
                        <div class="password-hint">Min. 8 characters. Must include number, lowercase and uppercase letter.</div>
                        <input type="password" name="password" id="password" autocomplete="off"> <!--required-->
                    </div>
                    <div class="register-field">
                        <label for="password_again">Repeat Password</label>
                        <input type="password" name="password_again" id="password_again" autocomplete="off"> <!--required-->
                    </div>
                </div>
            </div>
            <div class="register-button">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                <input type="submit" class="template-btn" value="register">
            </div>
        </form>
    </div>
</section>
<!-- Register Form Area End -->











