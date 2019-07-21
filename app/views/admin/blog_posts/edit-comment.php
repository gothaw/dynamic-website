<!-- Edit Comment Starts -->
<section id="edit-schedule" class="section-padding4">
    <div class="container">
        <h3 class="form-text">Edit Comment</h3>
        <form class="narrow-form" action="" method="post">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="comment_author">Author</label>
                        <input type="text" id="comment_author" name="comment_author" value="<?php echo escape(ucwords($data['selectedComment']['pc_author'])) ?>" autocomplete="off">
                    </div>
                    <div class="form-field-flex">
                        <div class="form-field">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php
                            if(isset($data['selectedComment']['pc_date'])) {
                                echo escape($data['selectedComment']['pc_date']);
                            } else{
                                echo date('Y-m-d');
                            }?>" required autocomplete="off">
                        </div>
                        <div class="form-field">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time" value="<?php
                            if(isset($data['selectedComment']['pc_time'])) {
                                echo substr(escape($data['selectedComment']['pc_time']),0,5);
                            } else{
                                echo date('H:i');
                            }?>" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-field">
                        <label for="comment_text">Comment Body</label>
                        <div>Max 2000 characters.</div>
                        <textarea class="form-text-area" name="comment_text" id="comment_text"
                                  required><?php echo escape($data['selectedComment']['pc_text']) ?></textarea>
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
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog' ?>">Back to Blog</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog/comments-delete/' . $data['selectedPost']['p_id'] . '/' . $data['selectedComment']['pc_id'] ?>">Delete Comment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Comment Ends -->