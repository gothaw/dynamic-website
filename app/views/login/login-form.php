<!-- Login Form Area Starts -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="login-text">
                    Please enter your username and password to login.
                </div>
                <form action="<?php echo ROOT . "login" ?>" method="post">
                    <div class="login-field">
                        <input type="text" placeholder="Enter username" name="username" id="username" required autocomplete="off">
                    </div>
                    <div class="login-field">
                        <input type="password" placeholder="Enter password" name="password" id="password" required autocomplete="off">
                    </div>
                    <div class="remember-me-field">
                        <label for="remember">
                            <input type="checkbox" name="remember" id="remember"> <span>Remember me</span>
                        </label>
                    </div>
                    <div class="login-button">
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        <input type="submit" class="template-btn" value="log in">
                    </div>
                </form>
                <div class="login-text">
                    If you don't have an account please register <a class="login-link" href="<?php echo ROOT .'register' ?>">here</a>.
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Form Area End -->