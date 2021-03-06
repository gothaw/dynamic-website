<!-- Add Coach Form Area Starts -->
<section class="section-padding4">
    <div class="container">
        <form class="wide-form" action="" method="post" enctype="multipart/form-data">
            <h3 class="form-text">Add Coach</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo escape(Input::getValue('first_name')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo escape(Input::getValue('last_name')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo escape(Input::getValue('email')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="coach_image">Upload Coach Image</label>
                        <div>Image to be 260x320. Max file size 500kB. Accepted file formats: .jpg, .jpeg, .png, .gif.</div>
                        <input class="form-field-file" type="file" name="coach_image" id="real-input" required>
                        <button type="button" class="browse-btn">Browse Files</button>
                        <span class="file-info">No file selected</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-field">
                        <label for="focus">Area of Focus</label>
                        <input type="text" name="focus" id="focus" value="<?php echo escape(Input::getValue('focus')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="facebook_profile">Facebook</label>
                        <input type="text" name="facebook_profile" id="facebook_profile" value="<?php echo escape(Input::getValue('facebook_profile')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="twitter_profile">Twitter</label>
                        <input type="text" name="twitter_profile" id="twitter_profile" value="<?php echo escape(Input::getValue('twitter_profile')) ?>" required autocomplete="off">
                    </div>
                    <div class="form-field">
                        <label for="linkedin_profile">Linkedin</label>
                        <input type="text" name="linkedin_profile" id="linkedin_profile" value="<?php echo escape(Input::getValue('linkedin_profile')) ?>" required autocomplete="off">
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
                <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-coaches' ?>">Back to Coaches</a>
                    </div>
                    <div>
                        <a class="template-btn"
                           href="<?php echo ROOT . 'admin-coaches/delete/' . escape($data['selectedCoach']['co_id']) ?>">Delete
                            Coach</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add Coach Form Area Ends -->