<!-- Blog Images Starts -->
<section class="section-padding3 section-padding5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <h3>Blog Post Image Gallery</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if(isset($data['defaultImage'])) {?>
                <div class="col-lg-6">
                    <div class="single-feature mb-5 mb-lg-0">
                        <div class="feature-img">
                            <img src="<?php echo DIST . escape($data['defaultImage']['p_img_url']) ?>" alt="<?php echo escape($data['defaultImage']['p_img_alt']) ?>">
                        </div>
                        <div class="feature-footer-default-img text-center">
                            <h5 ><?php echo escape($data['defaultImage']['p_img_alt']) ?></h5>
                            <p>Default Image</p>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php if(isset($data['images'])) {
                foreach ($data['images'] as $image){ ?>
                    <div class="col-lg-6">
                        <div class="single-feature mb-5 mb-lg-0">
                            <div class="feature-img">
                                <img src="<?php echo DIST . escape($image['p_img_url']) ?>" alt="<?php echo escape($image['p_img_alt']) ?>">
                                <div class="hover-state">
                                    <a href="<?php echo ROOT . $subName .'/delete/' . escape($image['p_img_id']) ?>" class="template-btn">delete</a>
                                </div>
                            </div>
                            <div class="feature-footer text-center">
                                <h5><?php echo escape($image['p_img_alt']) ?></h5>
                                <p></p>
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
                            <a class="template-btn" href="<?php echo ROOT . $subName . '/add' ?>">Add Image</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</section>
<!-- Blog Images Area Ends -->