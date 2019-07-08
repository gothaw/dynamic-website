<!-- Edit Post Form Area Starts -->
<?php trace($data['post'])?>
<section class="section-padding4">
    <div class="container">
        <form class="classes-form" action="" method="post" enctype="multipart/form-data">
            <h3 class="form-text">Edit Blog Post</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="post_title">Post Title</label>
                        <input type="text" name="post_title" id="post_title"
                               value="<?php echo escape(ucfirst($data['post']['p_title'])) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="post_category">Category</label>
                        <input type="text" name="post_category" id="post_category"
                               value="<?php echo escape(ucfirst($data['post']['p_category'])) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="post_author">Author</label>
                        <input type="text" name="post_author" id="post_author"
                               value="<?php echo escape(ucwords($data['post']['p_author'])) ?>" required
                               autocomplete="off">
                    </div>


                    <div class="form-field">
                        <label for="class_image">Upload Class Image</label>
                        <div>Image to be 360x270. Max file size 500kB. Accepted file formats: .jpg, .jpeg, .png, .giff.</div>
                        <input class="form-field-file" type="file" name="class_image" id="real-input">
                        <button type="button" class="browse-btn">Browse Files</button>
                        <span class="file-info"><?php
                            $urlArray = explode('/', escape($data['selectedClass']['cl_img_url']));
                            echo end($urlArray);
                            ?></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="class_image_text">Image Description</label>
                        <input type="text" name="class_image_text" id="max_no_people"
                               value="<?php echo escape($data['selectedClass']['cl_img_alt']) ?>"
                               required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="description">Class Description</label>
                        <textarea class="form-text-area" name="description" id="description"
                                  required><?php echo escape($data['selectedClass']['cl_desc']) ?></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
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
                        <a class="template-btn"
                           href="<?php echo ROOT . 'admin-classes/delete/' . escape($data['selectedClass']['cl_id']) ?>">Delete
                            Class</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Post Form Area Ends -->
