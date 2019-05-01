<!-- Dashboard Area Starts Here -->
<div class="container">
    <div class="row">
        <?php if ($data['admin']) { ?>
            <div class="col-lg-12">
                <section class="section-padding5">
                    <h3>Admin Panel</h3>
                    <div>You have admin rights. Click on the button below to access the admin panel.</div>
                    <div class="dashboard-button">
                        <a class="template-btn" href="<?php echo ROOT . 'admin/' ?>">Admin Panel</a>
                    </div>
                </section>
            </div>
        <?php } ?>
        <div class="col-lg-6">
            <section class="section-padding5">
                <h3>Your Details</h3>
                <ul class="user-details">
                    <li>First Name:</li>
                    <li><?php echo escape($data['user']['u_first_name']) ?></li>
                    <li>Last Name:</li>
                    <li><?php echo escape($data['user']['u_last_name']) ?></li>
                    <li>Address:</li>
                    <li><?php echo escape($data['user']['u_address_1']) ?></li>
                    <?php if (isset($data['user']['u_address_2'])) { ?>
                        <li></li>
                        <li><?php echo escape($data['user']['u_address_2']) ?></li>
                    <?php } ?>
                    <li>Postcode:</li>
                    <li><?php echo escape($data['user']['u_postcode']) ?></li>
                    <li>City:</li>
                    <li><?php echo escape($data['user']['u_city']) ?></li>
                    <li>Username:</li>
                    <li><?php echo escape($data['user']['u_username']) ?></li>
                    <li>Email:</li>
                    <li><?php echo escape($data['user']['u_email']) ?></li>
                </ul>
                <div class="dashboard-buttons-wrapper">
                    <div class="dashboard-button">
                        <a class="template-btn" href="<?php echo ROOT . 'dashboard/edit/' ?>">Edit</a>
                    </div>
                    <div class="dashboard-button">
                        <a class="template-btn" href="<?php echo ROOT . 'dashboard/changepass/' ?>">Change Password</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="section-padding5">
                <h3>Your Membership</h3>
                <?php if($data['validMembership']) {?>
                    <div>Membership active. You can visit our gym and sign up to classes.</div>
                    <div>Your membership expires on <?php echo escape($data['membership']) ?>.</div>
                    <div>You can extend you membership under link below.</div>
                <?php } else {?>
                    <div>Your membership has expired. Please renew it under link below.</div>
                <?php }?>
                <div class="dashboard-button">
                    <a class="template-btn" href="<?php echo ROOT . 'dashboard/membership/' ?>">Renew</a>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <section class="section-padding4">
                <section class="schedule-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-top text-center">
                                    <h3>Classes you signed up for</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="table-wrap col-lg-12">
                                <table class="schdule-table table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="head" scope="col">Class name</th>
                                        <th class="head" scope="col">Day</th>
                                        <th class="head" scope="col">Date</th>
                                        <th class="head" scope="col">Time</th>
                                        <th class="head" scope="col">Duration</th>
                                        <th class="head" scope="col">Trainer</th>
                                        <th class="head" scope="col">Quit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (isset($data['schedule'])) {
                                        foreach ($data['schedule'] as $class) { ?>
                                            <tr>
                                                <td class="name"><?php echo escape($class['cl_name']) ?></td>
                                                <td><?php echo date('l', strtotime(escape($class['sc_class_date']))) ?></td>
                                                <td><?php echo escape($class['sc_class_date']) ?></td>
                                                <td><?php echo substr(escape($class['sc_class_time']), 0, -3) ?></td>
                                                <td><?php echo escape($class['cl_duration']) ?></td>
                                                <td><?php echo ucwords(escape($class['co_first_name'] . " " . $class['co_last_name'])) ?></td>
                                                <td><a class="template-btn" href="<?php echo ROOT . 'dashboard/drop/' . escape($class['sc_id']) ?>">Drop</a></td>
                                            </tr>
                                        <?php }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </div>
</div>
<!-- Dashboard Area Ends Here -->

