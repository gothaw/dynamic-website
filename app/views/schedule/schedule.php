<!-- Schedule Area Starts -->
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-top text-center">
                    <h3>Upcoming Classes</h3>
                </div>
            </div>
        </div>
        <?php if (!empty($data['schedule'])) { ?>
        <div class="row justify-content-center">
            <div class="table-wrap col-lg-12">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th class="head" scope="col">Class name</th>
                        <th class="head" scope="col">Day</th>
                        <th class="head" scope="col">Date</th>
                        <th class="head" scope="col">Time</th>
                        <th class="head" scope="col">Duration</th>
                        <th class="head" scope="col">Trainer</th>
                        <?php if ($userIsLoggedIn) { ?>
                            <th class="head" scope="col">Join</th>
                        <?php } ?>
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
                                <?php if ($userIsLoggedIn) { ?>
                                    <td><a class="template-btn"
                                           href="<?php echo ROOT . 'schedule/signup/' . escape($class['sc_id']) ?>">Sign
                                            up</a></td>
                                <?php } ?>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
            <?php } else {
                echo "<p class='text-center'>There are no upcoming classes in the near future but feel free to visit our gym.</p>";
            }
            if (!$userIsLoggedIn) {
                ?>
                <div class="schedule-login-text">
                    <p>Would you like to sign up for a class? Please log in.</p>
                    <a href="<?php echo ROOT . 'login' ?>" class="template-btn">Login</a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Schedule Area End -->