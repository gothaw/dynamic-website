<!-- Banner Area Starts -->
<section class="banner-area banner-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-6 col-lg-7 offset-lg-5">
                <div class="banner-text">
                    <h1>Fight</h1>
                    <h1>For</h1>
                    <h2>Fitness</h2>
                    <div class="banner-btn">
                        <?php if ($userIsLoggedIn) { ?>
                            <a href="<?php echo ROOT . 'schedule' ?>" class="template-btn">sign up for a class</a>
                        <?php } else { ?>
                            <a href="<?php echo ROOT . 'login' ?>" class="template-btn">become a member</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Area End -->
