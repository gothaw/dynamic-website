<!-- Admin Comments Area Starts -->
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-top text-center">
                    <h3>Comments for approval</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="table-wrap col-lg-12">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th class="head" scope="col">Id</th>
                        <th class="head" scope="col">Post Title</th>
                        <th class="head" scope="col">Date</th>
                        <th class="head" scope="col">Time</th>
                        <th class="head" scope="col">Author</th>
                        <th class="head" scope="col">Edit</th>
                        <th class="head" scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($data['comments'])) {
                        foreach ($data['comments'] as $comment) { ?>
                            <tr>
                                <td class="name"><?php echo escape($comment['pc_id']) ?></td>
                                <td><?php echo escape(substr($comment['p_title'], 0, 25)) . '...' ?></td>
                                <td><?php echo escape($comment['pc_date']) ?></td>
                                <td><?php echo substr(escape($comment['pc_time']), 0, -3) ?></td>
                                <td><?php echo escape(ucwords($comment['pc_author'])) ?></td>
                                <td><a class="template-btn"
                                       href="<?php echo escape(ROOT . $subName . '/approve/' . $comment['p_id'] . '/' . $comment['pc_id']) ?>">Approve</a>
                                </td>
                                <td><a class="template-btn"
                                       href="<?php echo escape(ROOT . $subName  . '/delete/' . $comment['pc_id']) ?>">Delete</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <nav class="admin-pagination justify-content-center d-flex">
            <ul class="pagination">
                <li class="page-item">
                    <a href="<?php $previous = (intval($data['page']) !== 1) ? $data['page'] - 1 : '1';
                    echo ROOT . $subName . '/' . $previous; ?>" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">
                            <span class="fa fa-angle-left"></span>
                        </span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $data['lastPage']; $i++) {
                    if ($i === $data['page'] - 2 && $i > 1) { ?>
                        <li class="page-item"><span class="page-placeholder">...</span></li>
                    <?php }

                    if ($i === 1 || $i === intval($data['page']) || $i === intval($data['lastPage']) || $i === $data['page'] + 1 || $i === $data['page'] - 1) { ?>
                        <li class="page-item <?php if ($i === intval($data['page'])) {
                            echo 'active';
                        } ?>"><a href="<?php echo ROOT . $subName . '/' . $i ?>" class="page-link"><?php echo $i ?></a>
                        </li>

                    <?php }

                    if ($i === $data['page'] + 2 && $i < $data['lastPage']) { ?>
                        <li class="page-item"><span class="page-placeholder">...</span></li>
                    <?php }
                } ?>
                <li class="page-item">
                    <a href="<?php $next = ($data['page'] < $data['lastPage']) ? $data['page'] + 1 : $data['lastPage'];
                    echo ROOT . $subName . '/' . $next;
                    ?>"
                       class="page-link" aria-label="Next">
                        <span aria-hidden="true">
                            <span class="fa fa-angle-right"></span>
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="admin-navigate-buttons">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin' ?>">Back to Admin Panel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Admin Comments Area Ends -->