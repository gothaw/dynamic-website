<!-- Banner Area Starts -->
<section class="banner-area <?php if(isset($data['bannerIndex'])){ echo 'banner-area-' . $data['bannerIndex']; }?> banner-bg about-page text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-text">
                    <h3><?php echo $data['pageDetails']['pg_name']?></h3>
                    <a href="<?php echo ROOT?>">home</a>
                    <span class="mx-2">/</span>
                    <a href="<?php echo ROOT . $data['pageDetails']['pg_url']?>"><?php echo $data['pageDetails']['pg_name']?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Area End -->