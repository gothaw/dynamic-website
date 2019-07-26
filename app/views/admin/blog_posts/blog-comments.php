<!-- Post Comments Starts Here -->
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center">Comments under this post</h3>
            </div>
        </div>
        <?php if (!empty($data['comments'])) { ?>
            <div class="row justify-content-center section-padding5">
                <div class="table-wrap col-lg-12">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th class="head" scope="col">ID</th>
                            <th class="head" scope="col">Author</th>
                            <th class="head" scope="col">Date</th>
                            <th class="head" scope="col">Time</th>
                            <th class="head" scope="col">Text</th>
                            <th class="head" scope="col">Edit</th>
                            <th class="head" scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['comments'] as $comment) { ?>
                            <tr>
                                <td class="name"><?php echo escape($comment['pc_id']) ?></td>
                                <td><?php echo ucwords(escape($comment['pc_author'])) ?></td>
                                <td><?php echo escape($comment['pc_date']) ?></td>
                                <td><?php echo escape(substr($comment['pc_time'], 0, -3)) ?></td>
                                <td><?php echo escape(substr($comment['pc_text'], 0, 25)) . '...' ?></td>
                                <td>
                                    <a class="template-btn" href="<?php echo escape(ROOT . $subName . '-edit/' . $data['selectedPost']['p_id'] . '/' . $comment['pc_id']) ?>">Edit</a>
                                </td>
                                <td>
                                    <a class="template-btn" href="<?php echo escape(ROOT . $subName . '-delete/' . $data['selectedPost']['p_id'] . '/' . $comment['pc_id']) ?>">Remove</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else {
            echo "<p class='text-center p-4'>No comments under this post.</p>";
        } ?>
        <div class="row">
            <div class="col-lg-12 admin-navigate-buttons">
                <div>
                    <a class="template-btn" href="<?php echo escape(ROOT .  'admin-blog/edit/' . $data['selectedPost']['p_id']) ?>">Back to Post</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Post Comments Ends Here -->