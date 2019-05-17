<?php echo trace($data['classes']) ?>
<!-- Edit Class Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="update-form" action="<?php echo ROOT . "dashboard/edit" ?>" method="post">
            <h3 class="form-text">Edit Class</h3>
            <div class="form-text">
                Please update your personal details:
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="class_name">Class Name</label>
                        <input type="text" name="class_name" id="class_name"
                               value="<?php echo "class name" ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="description">Class Description</label>
                        <textarea class="form-text-area" name="description" id="description" required><?php echo "description" ?></textarea>
                    </div>
                    <div class="form-field">
                        <label for="duration">Duration (in minutes)</label>
                        <input type="text" name="duration" id="duration" value="<?php echo "duration" ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="max_no_people">Max Number of People</label>
                        <input type="text" name="max_no_people" id="max_no_people" value="<?php echo "max number of people" ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">

                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="update">
            </div>
        </form>
    </div>
</section>
<!-- Edit Class Form Area Ends -->
