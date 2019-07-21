<!-- Add Post Form Area Starts -->
<section id="add-post" class="section-padding4">
    <div class="container">
        <form class="wide-form" action="" method="post" enctype="multipart/form-data">
            <h3 class="form-text">Edit Blog Post</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="post_title">Post Title</label>
                        <input type="text" name="post_title" id="post_title"
                               value="<?php echo escape(Input::getValue('post_title')) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="post_category">Category</label>
                        <input type="text" name="post_category" id="post_category"
                               value="<?php echo escape(Input::getValue('post_category')) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="post_author">Author</label>
                        <input type="text" name="post_author" id="post_author"
                               value="<?php echo escape(ucwords(Input::getValue('post_author'))) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="post_tags">Tags</label>
                        <span>Separate tags using commas</span>
                        <input type="text" name="post_tags" id="post_tags"
                               value="<?php echo escape(Input::getValue('post_tags')) ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field-flex">
                        <div class="form-field">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php
                            if (Input::exists('date')) {
                                echo escape($data['date']);
                            } else {
                                echo date('Y-m-d');
                            } ?>" required autocomplete="off">
                        </div>
                        <div class="form-field">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time" value="<?php
                            if (Input::exists('time')) {
                                echo escape(Input::getValue('time'));
                            } else {
                                echo date('H:i');
                            } ?>" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="post_image">Image</label>
                        <select class="form-field-select" name="post_image" id="post_image">
                            <?php foreach ($data['images'] as $image) { ?>
                                <option value="<?php echo escape($image['p_img_id']) ?>" <?php
                                if ($image === $data['images'][0]) {
                                    echo "selected";
                                } ?>><?php echo ucfirst(escape($image['p_img_alt'])) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <div class="font-weight-bold pt-5">Image Thumbnail</div>
                        <div class="image-thumbnail-form">
                            <img id="post-image" class="img-responsive" src="<?php echo DIST . escape($data['images'][0]['p_img_url']) ?>"
                                 alt="<?php echo escape($data['images'][0]['p_img_alt']) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="post_text">Post Body</label>
                        <div>Max 5000 characters.</div>
                        <textarea class="form-text-area" name="post_text" id="post_text"
                                  required><?php echo escape(Input::getValue('post_text')) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-button">
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <input type="submit" class="template-btn" value="Add">
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog' ?>">Back to Posts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add Post Form Area Ends -->
