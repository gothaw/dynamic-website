<!-- Coaches Area Starts -->
<section class="coaches-area section-padding3 section-padding5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h3><?php
                        switch ($name){
                            case 'admin':
                                echo 'edit fitness coaches';
                            break;
                            default:
                                echo 'our fitness coaches';
                        }?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if(isset($data['coaches'])){
                foreach ($data['coaches'] as $coach){?>
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-coaches mb-5 mb-lg-0">
                            <div class="coaches-img">
                                <img src="<?php echo DIST . escape($coach['co_img']) ?>" alt="<?php echo escape($coach['co_first_name']) ?> photo">
                                <div class="hover-state">
                                    <?php switch ($name){
                                        case 'admin': ?>
                                    <div>
                                        <a class="template-btn" href="<?php echo ROOT . $subName . '/edit/' . escape($coach['co_id'])?>">Edit/Delete</a>
                                    </div>
                                    <?php break;
                                        default: ?>
                                    <ul>
                                        <li><a href="https://www.facebook.com/<?php echo escape($coach['co_facebook']) ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://www.twitter.com/<?php echo escape($coach['co_twitter']) ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/<?php echo escape($coach['co_linkedin']) ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="coaches-footer text-center">
                                <h5><?php echo escape($coach['co_first_name'] . ' ' . $coach['co_last_name']) ?></h5>
                                <h6><?php echo escape($coach['co_focus']) ?></h6>
                            </div>
                        </div>
                    </div>
            <?php }
            }?>
        </div>
        <?php if($name==='admin') {?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                        <div>
                            <a class="template-btn" href="<?php echo ROOT . 'admin' ?>">Back to Admin Panel</a>
                        </div>
                        <div>
                            <a class="template-btn" href="<?php echo ROOT . $subName . '/add' ?>">Add Coach</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</section>
<!-- Coaches Area End -->