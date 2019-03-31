<!-- Client Area Starts -->
<section class="client-area section-padding3 section-padding5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-top text-center">
                    <h3>client opinions</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="client-slider owl-carousel">
                    <?php if(isset($data['opinions'])){
                        foreach ($data['opinions'] as $opinion) {?>
                            <div class="single-slide d-flex">
                                <div class="slide-img mr-4">
                                    <img src="<?php echo DIST . $opinion['op_photo_url']?>" alt="photo-<?php echo $opinion['op_id']?>">
                                </div>
                                <div class="slide-text">
                                    <p><?php echo $opinion['op_desc']?></p>
                                    <h5><?php echo $opinion['op_client_name']?></h5>
                                    <h6><?php if(isset($opinion['cl_name'])){
                                            echo $opinion['cl_name'];
                                        }
                                        else{
                                            echo "Gym Member";
                                        }?>
                                    </h6>
                                </div>
                            </div>
                    <?php }
                    }?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Client Area End -->