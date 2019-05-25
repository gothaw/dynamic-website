<!-- Delete Item Area -->
<section class="section-padding4">
    <div class="container">
        <form action="" method="post">
            <h3 class="form-text">Delete <?php echo $data['itemToBeDeleted'] ?></h3>
            <div class="form-text form-text-bold">Do you wish to delete selected <?php echo $data['itemToBeDeleted'] ?>?</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                        <div>
                            <input class="template-btn" type="submit" value="Yes">
                            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        </div>
                        <div>
                            <a class="template-btn" href="<?php

                                    echo ROOT . explode('/',$subName)[0];

                            ?>">No</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Delete Item Area -->