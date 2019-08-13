<!-- Users in Scheduled Class Starts Here -->
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center">Users that signed up to this class</h3>
            </div>
        </div>
        <?php if (!empty($data['users'])) { ?>
            <div class="row justify-content-center section-padding5">
                <div class="table-wrap col-lg-12">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th class="head" scope="col">ID</th>
                            <th class="head" scope="col">First Name</th>
                            <th class="head" scope="col">Last Name</th>
                            <th class="head" scope="col">Username</th>
                            <th class="head" scope="col">Email</th>
                            <?php if($data['scheduledClass']['sc_class_date'] > date('Y-m-d') || ($data['scheduledClass']['sc_class_date'] == date('Y-m-d') && $data['scheduledClass']['sc_class_time'] > date('H:i'))) {?>
                            <th class="head" scope="col">Delete</th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['users'] as $user) { ?>
                            <tr>
                                <td class="name"><?php echo escape($user['u_id']) ?></td>
                                <td><?php echo ucfirst(escape($user['u_first_name'])) ?></td>
                                <td><?php echo ucfirst(escape($user['u_last_name'])) ?></td>
                                <td><?php echo escape($user['u_username']) ?></td>
                                <td><?php echo escape($user['u_email']) ?></td>
                                <?php if($data['scheduledClass']['sc_class_date'] > date('Y-m-d') || ($data['scheduledClass']['sc_class_date'] == date('Y-m-d') && $data['scheduledClass']['sc_class_time'] > date('H:i'))) {?>
                                <td><a class="template-btn"
                                       href="<?php echo ROOT . $subName . '-delete/' . escape($data['scheduledClass']['sc_id']) . '/' . escape($user['u_id']) ?>">Remove</a>
                                </td>
                                <?php }?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else {
            echo "<p class='text-center p-4'>No users signed up to this class.</p>";
        } ?>
        <div class="row">
            <div class="col-lg-12 section-padding5">
                <?php if($data['scheduledClass']['sc_class_date'] > date('Y-m-d') || ($data['scheduledClass']['sc_class_date'] == date('Y-m-d') && $data['scheduledClass']['sc_class_time'] > date('H:i'))) { ?>
                <p class="form-text font-weight-bold">You can add user to the class by entering user ID and clicking sign up button.</p>
                <form class="search-form" action="" method="post">
                    <div class="search-field-wrapper">
                        <input class="search-field" type="text" name="user_id"
                               placeholder="ID number" onfocus="this.placeholder = ''"
                               onblur="this.placeholder = 'ID number'" required>
                    </div>
                    <div class="submit-button-wrapper">
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        <button type="submit" name="submit" class="template-btn">sign up</button>
                    </div>
                </form>
                <?php } else {?>
                    <p class="form-text font-weight-bold">You cannot sign up any more users to class that was in the past.</p>
                <?php }?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 admin-navigate-buttons">
                <div>
                    <a class="template-btn" href="<?php echo ROOT . 'admin-schedule/edit/' . escape($data['scheduledClass']['sc_id']) ?>">Back to Scheduled Class</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Users in Scheduled Class Ends Here -->