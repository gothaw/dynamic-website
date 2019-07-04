<!--================Blog Area =================-->
<div class="col-lg-8 posts-list">
    <div class="single-post row">
        <div class="col-lg-12">
            <div class="feature-img">
                <img class="img-fluid" src="<?php echo DIST . escape($data['post']['p_img_url']) ?>" alt="<?php echo escape($data['post']['p_img_alt']) ?>">
            </div>
        </div>
        <div class="col-lg-3  col-md-3">
            <div class="blog_info text-right">
                <div class="post_tag">
                    <?php if (isset($data['post']['p_tags'])) {
                        foreach ($data['post']['p_tags'] as $tag) { ?>
                            <a href="<?php echo ROOT . 'blog/tag/' . escape(str_replace(' ', '_', $tag)) ?>"><?php echo escape(ucfirst($tag)) ?></a>
                        <?php }
                    } ?>
                </div>
                <ul class="blog_meta list">
                    <li><span><?php echo escape(ucwords($data['post']['p_author'])) ?><i class="fa fa-user-o"></i></span></li>
                    <li><span><?php echo escape(ucfirst($data['post']['p_category'])) ?><i class="fa fa-tag"></i></span></li>
                    <li><span><?php echo escape($data['post']['p_date']) ?><i class="fa fa-calendar-o"></i></span></li>
                    <li><span><?php echo escape(substr($data['post']['p_time'],0,5)) ?><i class="fa fa-clock-o"></i></span></li>
                    <li><span><?php echo escape($data['post']['p_comments']) ?> Comments<i class="fa fa-comment-o"></i></span></li>
                </ul>
                <ul class="social-links">
                    <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://github.com/"><i class="fa fa-github"></i></a></li>
                    <li><a href="https://www.linkedin.com" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 blog_details">
            <h5><?php echo escape(ucwords($data['post']['p_title'])) ?></h5>
            <div class="blog_details">
                <?php if(isset($data['post']['p_text'])){
                    foreach ($data['post']['p_text'] as $paragraph){ ?>
                        <p><?php echo escape($paragraph) ?></p>
                    <?php }
                } ?>
            </div>
        </div>
        <div class="blog-button-wrapper col-lg-12 section-padding5">
            <a href="<?php echo ROOT . 'blog/' ?>" class="template-btn blog-button">Other Posts</a>
        </div>
    </div>
    <div class="comments-area">
        <h4><?php echo escape($data['post']['p_comments']) ?> Comments</h4>
        <div class="comment-list">
            <div class="single-comment">
                <?php if(isset($data['postComments']) && !empty($data['postComments'])) {
                    foreach ($data['postComments'] as $comment) { ?>
                    <div class="user">
                        <div class="desc">
                            <h5><?php echo escape($comment['pc_author']) ?></h5>
                            <p class="date"><?php echo escape($comment['pc_date'] . ', ' . $comment['pc_time']) ?></p>
                            <p class="comment"><?php echo escape($comment['pc_text']) ?></p>
                        </div>
                    </div>
                <?php }
                } else { ?>
                    <div class="user">
                        <div class="desc">
                            <p class="comment">
                                No comments so far. Feel free to comment.
                            </p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<!--================Blog Area =================-->