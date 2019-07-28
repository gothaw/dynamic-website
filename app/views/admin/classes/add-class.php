<!-- Add Class Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="wide-form" action="" method="post" enctype="multipart/form-data">
            <h3 class="form-text">Add New Class</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="class_name">Class Name</label>
                        <input type="text" name="class_name" id="class_name"
                               value="<?php echo escape(Input::getValue('class_name')) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="duration">Duration (in minutes, less than 120)</label>
                        <input type="number" min="15" max="120" name="duration" id="duration"
                               value="<?php echo escape(Input::getValue('duration')) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="max_no_people">Max Number of People (no more than 35)</label>
                        <input type="number" min="5" max="35" name="max_no_people" id="max_no_people"
                               value="<?php echo escape(Input::getValue('max_no_people')) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="class_image">Upload Class Image</label>
                        <div>Image to be 360x270. Max file size 500kB. Accepted file formats: .jpg, .jpeg, .png, .gif.</div>
                        <input class="form-field-file" type="file" name="class_image" id="real-input" required>
                        <button type="button" class="browse-btn">Browse Files</button>
                        <span class="file-info">No file selected</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="class_image_text">Image Description</label>
                        <input type="text" name="class_image_text" id="max_no_people"
                               value="<?php echo escape(Input::getValue('class_image_text')) ?>"
                               required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="description">Class Description</label>
                        <textarea class="form-text-area" name="description" id="description"
                                  required><?php echo escape(Input::getValue('description')) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="add">
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-classes' ?>">Back to Classes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add Class Form Area Ends -->