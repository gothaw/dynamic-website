<!-- Feature Area Starts -->
    <section class="feature-area section-padding3 section-padding5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3><?php
                            if($data['pageDetails']['pg_name']==='about'){
                                echo "our classes";
                            } else{
                                echo "featured classes";
                            }?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if(isset($data['classes'])) {
                    foreach ($data['classes'] as $class){ ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-feature mb-5 mb-lg-0">
                                <div class="feature-img">
                                    <img src="<?php echo DIST . escape($class['cl_img_url']) ?>" alt="<?php echo escape($class['cl_img_alt']) ?>">
                                    <?php if($name !== 'schedule'){?>
                                    <div class="hover-state">
                                        <a href="<?php echo ROOT . 'schedule/'?>" class="template-btn">schedule</a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="feature-footer text-center">
                                    <h5><?php echo escape($class['cl_name']) ?></h5>
                                    <p><?php echo escape($class['cl_desc']) ?></p>
                                </div>
                            </div>
                        </div>
                <?php }
                }?>
            </div>
        </div>
    </section>
    <!-- Feature Area End -->