<!-- Edit Comment Starts -->
<section id="edit-schedule" class="section-padding4">
    <div class="container">
        <h3 class="form-text">Edit Comment</h3>
        <form class="schedule-form" action="" method="post">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" value="<?php ?>" autocomplete="off">
                    </div>
                    <div class="form-field-flex">
                        <div class="form-field">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php
                            if(isset($data['scheduledClass']['sc_class_date'])) {
                                echo escape($data['scheduledClass']['sc_class_date']);
                            } else{
                                echo date('Y-m-d');
                            }?>" required autocomplete="off">
                        </div>
                        <div class="form-field">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time" value="<?php
                            if(isset($data['scheduledClass']['sc_class_time'])) {
                                echo substr(escape($data['scheduledClass']['sc_class_time']),0,5);
                            } else{
                                echo date('H:i');
                            }?>" required autocomplete="off">
                        </div>
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
                        <a class="template-btn" href="<?php echo ROOT . 'admin-schedule' ?>">Back to Schedule</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-schedule/users/' . escape($data['scheduledClass']['sc_id']) ?>">View Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Comment Ends -->