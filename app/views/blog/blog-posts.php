<!--Blog Posts Area-->
<?php
    /*$text = $data['posts'][0]['p_text'];
    trace(substr_count($text,'<p>'));
    $text1 = str_replace('<p>','',$text);
    $text1exploded = explode('</p>',$text1);
    array_pop($text1exploded);
    trace($text1exploded);
    echo strlen($text1exploded[0]);*/
?>
<div class="col-lg-8">
    <div class="blog_left_sidebar">
        <?php if (isset($data['posts'])) {
            foreach ($data['posts'] as $post) {
                ?>
                <article class="row blog_item">
                    <div class="col-md-3">
                        <div class="blog_info text-right">
                            <div class="post_tag">
                                <a href="#">Food,</a>
                                <a class="active" href="#">Technology,</a>
                                <a href="#">Politics,</a>
                                <a href="#">Lifestyle</a>
                            </div>
                            <ul class="blog_meta list">
                                <li><a href="#"><?php echo escape(ucwords($post['p_author'])) ?><i class="fa fa-user-o"></i></a></li>
                                <li><a href="#"><?php echo escape(ucfirst($post['p_category'])) ?><i class="fa fa-tag"></i></a></li>
                                <li><a href="#"><?php echo escape($post['p_date']) ?><i class="fa fa-calendar-o"></i></a></li>
                                <li><a href="#"><?php echo escape(substr($post['p_time'],0,5)) ?><i class="fa fa-clock-o"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="blog_post">
                            <img src="<?php echo DIST . escape($post['p_img_url']) ?>" alt="<?php echo escape($post['p_img_alt']) ?>">
                            <div class="blog_details">
                                <a href="#"><h4><?php echo escape(ucwords($post['p_title'])) ?></h4></a>
                                <p><?php echo escape($post['p_summary']) ?></p>
                                <a href="#" class="template-btn">View More</a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php }
        } ?>
        <nav class="blog-pagination justify-content-center d-flex">
            <ul class="pagination">
                <li class="page-item">
                    <a href="#" class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">
                                            <span class="fa fa-angle-left"></span>
                                        </span>
                    </a>
                </li>
                <li class="page-item"><a href="#" class="page-link">01</a></li>
                <li class="page-item active"><a href="#" class="page-link">02</a></li>
                <li class="page-item"><a href="#" class="page-link">03</a></li>
                <li class="page-item"><a href="#" class="page-link">04</a></li>
                <li class="page-item"><a href="#" class="page-link">09</a></li>
                <li class="page-item">
                    <a href="#" class="page-link" aria-label="Next">
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