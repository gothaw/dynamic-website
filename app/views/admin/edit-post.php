<!-- Edit Post Form Area Starts -->
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
                        <label for="post_tags">Tags</label>
                        <input type="text" name="post_tags" id="post_tags"
                               value="<?php
                               $size = count($data['post']['p_tags']);
                               for ($i = 0; $i < $size; $i++) {
                                   echo escape(ucwords($data['post']['p_tags'][$i]));
                                   if ($i < $size - 1) {
                                       echo ', ';
                                   }
                               } ?>" required
                               autocomplete="off">
                    </div>
                    <div class="form-field-flex">
                        <div class="form-field">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php
                            if (isset($data['post']['p_date'])) {
                                echo escape($data['post']['p_date']);
                            } else {
                                echo date('Y-m-d');
                            } ?>" required autocomplete="off">
                        </div>
                        <div class="form-field">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time" value="<?php
                            if (isset($data['post']['p_time'])) {
                                echo substr(escape($data['post']['p_time']), 0, 5);
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
                                if ($image['p_img_id'] === $data['post']['p_img_id']) {
                                    echo "selected";
                                } ?>><?php echo ucfirst(escape($image['p_img_alt'])) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <div class="font-weight-bold pt-5">Image Thumbnail</div>
                        <div class="image-thumbnail-form">
                            <img class="img-responsive" src="<?php echo DIST . escape($data['post']['p_img_url']) ?>"
                                 alt="<?php echo escape($data['post']['p_img_alt']) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="description">Post Body</label>
                        <textarea class="form-text-area" name="description" id="description"
                                  required><?php echo escape($data['post']['p_text']) ?></textarea>
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
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog' ?>">Back to Posts</a>
                    </div>
                    <div>
                        <a class="template-btn"
                           href="<?php echo ROOT . 'admin-blog/delete/' . escape($data['post']['p_id']) ?>">Delete
                            Post</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog' ?>">View Post Comments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Post Form Area Ends -->
