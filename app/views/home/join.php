<!-- Join Area Starts -->
<section class="friend-area section-padding text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if ($userIsLoggedIn) { ?>
                    <h3>Check our classes!</h3>
                    <h4 class="pt-3 pb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae commodi minima.</h4>
                    <a href="<?php echo ROOT . 'schedule/'?>" class="template-btn">schedule</a>
                <?php } else { ?>
                    <h3>Join our gym today!</h3>
                    <h4 class="pt-3 pb-4">Give dry stars form us called won't winged had abundantly land Midst appear for you eden</h4>
                    <a href="<?php echo ROOT . 'login/'?>" class="template-btn">join us</a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- Join Area End -->