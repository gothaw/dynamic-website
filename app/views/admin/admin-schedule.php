<!-- Admin Schedule Starts -->
<?php trace(intval($data['lastPage']) === 8);?>
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-top text-center">
                    <h3>Scheduled Classes</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="table-wrap col-lg-12">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th class="head" scope="col">Class Name</th>
                        <th class="head" scope="col">Day</th>
                        <th class="head" scope="col">Date</th>
                        <th class="head" scope="col">Time</th>
                        <th class="head" scope="col">Duration</th>
                        <th class="head" scope="col">Trainer</th>
                        <th class="head" scope="col">Edit</th>
                        <th class="head" scope="col">Delete</th>
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
                                <td><a class="template-btn" href="<?php echo ROOT . $subName . '/edit' ?>">Edit</a></td>
                                <td><a class="template-btn" href="<?php echo ROOT . $subName . '/delete' ?>">Delete</a></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <nav class="blog-pagination justify-content-center d-flex">
            <ul class="pagination">
                <li class="page-item">
                    <a href="<?php echo ($data['page'] !== '1') ? $data['page'] - 1 : '1'; ?>" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">
                            <span class="fa fa-angle-left"></span>
                        </span>
                    </a>
                </li>
                <?php for($i = 1; $i <= $data['lastPage']; $i++) {

                    trace($i === $data['lastPage']);

                    if ($i === 1 || $i === intval($data['page']) || $i === intval($data['lastPage']) || $i === $data['page'] + 1 || $i === $data['page'] - 1){ ?>
                    <li class="page-item <?php if ($i === intval($data['page'])) { echo 'active'; } ?>"><a href="<?php echo $i ?>" class="page-link"><?php echo $i?></a></li>
                <?php } }?>


                <!--<li class="page-item"><a href="#" class="page-link"><?php /*echo '1' */?></a></li>
                <?php /*if($data['page'] > 3) {*/?>
                    <li class="page-item">...</li>
                <?php /*}*/?>
                <li class="page-item active"><a href="#" class="page-link"><?php
/*                    if($data['page'] > 1 )
                        escape($data['page']+1)

                */?></a></li>
                <li class="page-item"><a href="#" class="page-link">3</a></li>
                <li class="page-item"><a href="#" class="page-link">4</a></li>
                <li class="page-item">...</li>
                <li class="page-item"><a href="#" class="page-link">9</a></li>-->
                <li class="page-item">
                    <a href="<?php echo ($data['page'] < $data['lastPage']) ? $data['page'] + 1 : $data['lastPage']; ?>" class="page-link" aria-label="Next">
                        <span aria-hidden="true">
                            <span class="fa fa-angle-right"></span>
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin' ?>">Back to Admin Panel</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . $subName . '/add' ?>">Add Class</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Admin Schedule Ends -->
