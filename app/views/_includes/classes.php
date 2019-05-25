<!-- Feature Area Starts -->
<section class="<?php if($name !== 'admin') {echo 'feature-area';} ?> section-padding3 section-padding5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="<?php if($name !== 'admin') {echo 'text-center';} ?>">
                    <h3><?php
                        switch ($name){
                            case 'about':
                                echo 'Our classes';
                                break;
                            case 'admin':
                                echo 'Edit Classes';
                                break;
                            default:
                                echo "featured classes";
                        } ?>
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
                                <?php switch ($name){
                                    case 'admin': ?>
                                <div class="hover-state">
                                    <a href="<?php echo ROOT . $subName .'/edit/' . $class['cl_id']?>" class="template-btn">edit/delete</a>
                                </div>
                                    <?php break;
                                    case 'schedule':
                                        break;
                                    default: ?>
                                <div class="hover-state">
                                    <a href="<?php echo ROOT . 'schedule'?>" class="template-btn">schedule</a>
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
        <?php if($name==='admin') {?>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin' ?>">Back to Admin Panel</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . $subName . '/add' ?>">Add Class</a>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</section>
<!-- Feature Area End -->