<!-- Feature Area Starts -->
    <section class="feature-area section-padding3 section-padding5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top text-center">
                        <h3>featured classes</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if(isset($data['classes'])) {
                    foreach ($data['classes'] as $class){ ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-feature mb-5 mb-lg-0">
                                <div class="feature-img">
                                    <img src="<?php echo DIST . $class['cl_img_url']?>" alt="<?php echo $class['cl_img_alt']?>">
                                    <div class="hover-state">
                                        <a href="#" class="template-btn">schedule</a>
                                    </div>
                                </div>
                                <div class="feature-footer text-center">
                                    <h5><?php echo $class['cl_name']?></h5>
                                    <p><?php echo $class['cl_desc']?></p>
                                </div>
                            </div>
                        </div>
                <?php }
                }?>
            </div>
        </div>
    </section>
    <!-- Feature Area End -->