<!-- Edit Scheduled Class Starts -->
<?php trace($data); ?>
<section class="section-padding4">
    <div class="container">
        <h3 class="form-text">Update Scheduled Class</h3>
        <form class="schedule-form" action="" method="post">
            <div class="form-text">
                Fill the fields below to update scheduled class.
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-field">
                        <label for="class">Class</label>
                        <select class="form-field-select" name="class" id="class">
                            <?php foreach ($data['classes'] as $class) { ?>
                                <option value="<?php echo escape($class['cl_id']) ?>" <?php
                                if ($class['cl_id'] === $data['selectedClass']['cl_id']) {
                                    echo "selected";
                                } ?>><?php echo ucfirst(escape($class['cl_name'] . ' (' . $class['cl_duration'] . ' mins)')) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="coach">Coach</label>
                        <select class="form-field-select" name="class" id="class">
                            <?php foreach ($data['coaches'] as $coach) { ?>
                                <option value="<?php echo escape($coach['co_id']) ?>" <?php
                                if ($coach['co_id'] === $data['selectedClass']['co_id']) {
                                    echo "selected";
                                } ?>><?php echo ucwords(escape($coach['co_first_name'] . ' ' . $coach['co_last_name'])) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-field-flex">
                        <div class="form-field">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php
                            if(isset($data['expiryDate'])) {
                                echo escape($data['expiryDate']);
                            } else{
                                echo date('Y-m-d');
                            }?>" required autocomplete="off">
                        </div>
                        <div class="form-field">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time" value="<?php
                            if(isset($data['selectedClass']['sc_class_date'])){

                            }
                            ?>">
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
                <div class="admin-navigate-buttons">
                    <a class="template-btn" href="<?php echo ROOT . 'admin-schedule' ?>">Back to Schedule</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Scheduled Class Ends -->

