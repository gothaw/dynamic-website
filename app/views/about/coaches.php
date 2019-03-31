<!-- Coaches Area Starts -->
<section class="coaches-area section-padding3 section-padding5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h3>our fitness coaches</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if(isset($data['coaches'])){
                foreach ($data['coaches'] as $coach){?>
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-coaches mb-5 mb-lg-0">
                            <div class="coaches-img">
                                <img src="<?php echo DIST . $coach['co_img']?>" alt="<?php echo $coach['co_first_name']?> photo">
                                <div class="hover-state">
                                    <ul>
                                        <li><a href="https://www.facebook.com/<?php echo $coach['co_facebook']?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://www.twitter.com/<?php echo $coach['co_twitter']?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/<?php echo $coach['co_linkedin']?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="coaches-footer text-center">
                                <h5><?php echo $coach['co_first_name'] . ' ' . $coach['co_last_name']?></h5>
                                <h6><?php echo $coach['co_focus']?></h6>
                            </div>
                        </div>
                    </div>
            <?php }
            }?>

        </div>
    </div>
</section>
<!-- Coaches Area End -->