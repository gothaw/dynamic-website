<!-- Edit Class Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="classes-form" action="" method="post" enctype="multipart/form-data">
            <h3 class="form-text">Edit/Delete Class</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="class_name">Class Name</label>
                        <input type="text" name="class_name" id="class_name"
                               value="<?php echo escape($data['selectedClass']['cl_name']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="duration">Duration (in minutes, less than 120)</label>
                        <input type="text" name="duration" id="duration" value="<?php echo escape($data['selectedClass']['cl_duration']) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="max_no_people">Max Number of People (less than 30)</label>
                        <input type="text" name="max_no_people" id="max_no_people"
                               value="<?php echo escape($data['selectedClass']['cl_max_people']) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="class_image">Upload Class Image</label>
                        <input class="form-field-file" type="file" name="class_image" id="real-input">
                        <button type="button" class="browse-btn">Browse Files</button>
                        <span class="file-info"><?php echo explode('/',escape($data['selectedClass']['cl_img_url']))[2] ?></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="class_image_text">Image Description</label>
                        <input type="text" name="class_image_text" id="max_no_people" value="<?php echo escape($data['selectedClass']['cl_img_alt']) ?>"
                               required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="description">Class Description</label>
                        <textarea class="form-text-area" name="description" id="description"
                                  required><?php echo escape($data['selectedClass']['cl_desc']) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="update">
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-classes' ?>">Back to Classes</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-classes/delete/' . escape($data['selectedClass']['cl_id']) ?>">Delete
                            Class</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Class Form Area Ends -->
