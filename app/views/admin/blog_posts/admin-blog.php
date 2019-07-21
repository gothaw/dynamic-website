<!-- Admin Schedule Starts -->
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-top text-center">
                    <h3>Blog Posts</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="table-wrap col-lg-12">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th class="head" scope="col">Id</th>
                        <th class="head" scope="col">Title</th>
                        <th class="head" scope="col">Category</th>
                        <th class="head" scope="col">Date</th>
                        <th class="head" scope="col">Time</th>
                        <th class="head" scope="col">Author</th>
                        <th class="head" scope="col">Comments</th>
                        <th class="head" scope="col">Edit</th>
                        <th class="head" scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($data['posts'])) {
                        foreach ($data['posts'] as $post) { ?>
                            <tr>
                                <td class="name"><?php echo escape($post['p_id']) ?></td>
                                <td><?php echo escape(substr($post['p_title'], 0, 20)) . '...' ?></td>
                                <td><?php echo escape(ucfirst($post['p_category'])) ?></td>
                                <td><?php echo escape($post['p_date']) ?></td>
                                <td><?php echo substr(escape($post['p_time']), 0, -3) ?></td>
                                <td><?php echo escape(ucwords($post['p_author'])) ?></td>
                                <td><?php echo escape($post['p_comments']) ?></td>
                                <td><a class="template-btn"
                                       href="<?php echo ROOT . $subName . '/edit/' . escape($post['p_id']) ?>">Edit</a>
                                </td>
                                <td><a class="template-btn"
                                       href="<?php echo ROOT . $subName . '/delete/' . escape($post['p_id']) ?>">Delete</a>
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
                <div class="admin-navigate-buttons admin-navigate-buttons-flex">
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin' ?>">Back to Admin Panel</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . $subName . '/add' ?>">Add Post</a>
                    </div>
                    <div>
                        <a class="template-btn" href="<?php echo ROOT . 'admin-blog-images' ?>">Images Gallery</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Admin Schedule Ends -->
