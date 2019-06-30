<!--Blog Posts Area-->
<div class="col-lg-8">
    <div class="blog_left_sidebar">
        <?php if (isset($data['posts'])) {
            foreach ($data['posts'] as $post) {
                ?>
                <article class="row blog_item">
                    <div class="col-md-3">
                        <div class="blog_info text-right">
                            <ul class="blog_meta list">
                                <li><span><?php echo escape(ucwords($post['p_author'])) ?><i class="fa fa-user-o"></i></span></li>
                                <li><span><?php echo escape(ucfirst($post['p_category'])) ?><i class="fa fa-tag"></i></span></li>
                                <li><span><?php echo escape($post['p_date']) ?><i class="fa fa-calendar-o"></i></span></li>
                                <li><span><?php echo escape(substr($post['p_time'],0,5)) ?><i class="fa fa-clock-o"></i></span></li>
                                <li><span><?php echo escape($post['p_comments']) ?> Comments<i class="fa fa-comment-o"></i></span></li>
                            </ul>
                            <div class="post_tag">
                                <?php if (isset($post['p_tags'])) {
                                    foreach ($post['p_tags'] as $tag) { ?>
                                        <a href="<?php echo ROOT . 'blog/tag/' . escape(str_replace(' ', '_', $tag)) ?>"><?php echo escape(ucfirst($tag)) ?></a>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="blog_post">
                            <img src="<?php echo DIST . escape($post['p_img_url']) ?>" alt="<?php echo escape($post['p_img_alt']) ?>">
                            <div class="blog_details">
                                <a href="<?php echo ROOT . 'blog/post/' . escape($post['p_id']) ?>"><h4><?php echo escape(ucwords($post['p_title'])) ?></h4></a>
                                <p><?php echo escape($post['p_summary']) ?></p>
                                <a href="<?php echo ROOT . 'blog/post/' . escape($post['p_id']) ?>" class="template-btn">View More</a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php }
        } ?>
        <nav class="blog-pagination justify-content-center d-flex">
            <ul class="pagination">
                <li class="page-item">
                    <a href="<?php  $previous = (intval($data['page']) !== 1) ? $data['page'] - 1 : '1';
                    echo ROOT . $subName . '/' . $previous; ?>" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">
                            <span class="fa fa-angle-left"></span>
                        </span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $data['lastPage']; $i++) {
                    if ($i === $data['page'] - 2 && $i > 1 ) { ?>
                        <li class="page-item"><span class="page-placeholder">...</span></li>
                    <?php }

                    if ($i === 1 || $i === intval($data['page']) || $i === intval($data['lastPage']) || $i === $data['page'] + 1 || $i === $data['page'] - 1) { ?>
                        <li class="page-item <?php if ($i === intval($data['page'])) {
                            echo 'active';
                        } ?>"><a href="<?php echo ROOT . $subName . '/' . $i ?>" class="page-link"><?php echo $i ?></a>
                        </li>

                    <?php }

                    if ($i === $data['page'] + 2 && $i < $data['lastPage'] ) { ?>
                        <li class="page-item"><span class="page-placeholder">...</span></li>
                    <?php }
                } ?>
                <li class="page-item">
                    <a href="<?php  $next = ($data['page'] < $data['lastPage']) ? $data['page'] + 1 : $data['lastPage'];
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
    </div>
</div>
<!--Blog Posts Area-->