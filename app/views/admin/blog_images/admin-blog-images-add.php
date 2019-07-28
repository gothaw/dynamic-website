<!-- Add Blog Image Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <h3 class="form-text">Add New Blog Post Image</h3>
        <form class="narrow-form" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="post_image">Upload Blog Post Image</label>
                        <div>Image to be 790x445. Max file size 500kB. Accepted file formats: .jpg, .jpeg, .png, .gif.</div>
                        <input class="form-field-file" type="file" name="post_image" id="real-input" required>
                        <button type="button" class="browse-btn">Browse Files</button>
                        <span class="file-info">No file selected</span>
                    </div>
                    <div class="form-field">
                        <label for="post_image_text">Image Description</label>
                        <input type="text" name="post_image_text" id="max_no_people"
                               value="<?php echo escape(Input::getValue('post_image_text')) ?>"
                               required autocomplete="off">
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
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog-images' ?>">Back to Gallery</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add Blog Image Form Area Ends -->