<!-- Banner Area Starts -->
<section class="banner-area <?php
    if(isset($data['pageDetails']['pg_banner'])) {
        echo 'banner-area-' . escape($data['pageDetails']['pg_banner']);
    }?> banner-bg about-page text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-text">
                    <?php if($name === 'dashboard' || $name === 'admin') {?>
                        <h3><?php echo escape("Welcome {$data['user']['u_first_name']}!")?></h3>
                    <?php } else {?>
                        <h3><?php echo escape($data['pageDetails']['pg_name']) ?></h3>
                    <?php }?>
                    <a href="<?php echo ROOT?>">home</a>
                    <span class="mx-2">/</span>
                    <a href="<?php echo ROOT . escape($data['pageDetails']['pg_url']) ?>"><?php echo escape($data['pageDetails']['pg_name']) ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Area End -->