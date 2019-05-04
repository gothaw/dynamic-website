<!-- Admin Area Starts Here -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <section class="section-padding4">
                <h3>View Membership</h3>
                <form class="search-form" action="<?php echo ROOT . 'admin/membership/' ?>" method="post">
                    <div class="search-field-wrapper">
                        <input class="search-field" type="text" name="search" placeholder="Username, Last Name, ID number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username, Last Name, ID number'" required>
                    </div>
                    <div class="search-button-wrapper">
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        <button type="submit" name="submit" class="template-btn">search</button>
                    </div>
                </form>
                <?php // search results go here ?>
                <div class="back-to-admin-panel">
                    <a class="template-btn" href="<?php echo ROOT . 'admin/' ?>">Back to Admin Panel</a>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- Admin Area Ends Here -->