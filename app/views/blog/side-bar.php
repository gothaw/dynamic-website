<!--Side Bar Area-->
<div class="col-lg-4">
    <div class="blog_right_sidebar">
        <aside class="single_sidebar_widget author_widget">
            <h4 class="widget_title">Blog Writer</h4>
            <div class="br"></div>
            <img class="author_img rounded-circle" src="<?php echo DIST ?>img/blog/author.jpg" alt="blog author">
            <h5>Jamie Hart</h5>
            <p>Trainer</p>
            <div class="social_icon">
                <a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook"></i></a>
                <a href="https://twitter.com/twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="https://www.linkedin.com" target="_blank"><i class="fa fa-linkedin"></i></a>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A at consectetur consequatur cum debitis eius
                esse labore libero minima, minus, molestiae nam nemo odio odit quidem quos totam voluptate
                voluptatibus.</p>
            <div class="br"></div>
        </aside>
        <aside class="single_sidebar_widget popular_post_widget">
            <h4 class="widget_title">Other Posts</h4>
            <div class="media post_item">
                <img src="<?php echo DIST ?>img/blog/popular-post/post1.jpg" alt="post">
                <div class="media-body">
                    <a href="#"><h5>Space The Final Frontier</h5></a>
                    <p>02 Hours ago</p>
                </div>
            </div>
            <div class="media post_item">
                <img src="<?php echo DIST ?>img/blog/popular-post/post2.jpg" alt="post">
                <div class="media-body">
                    <a href="#"><h5>The Amazing Hubble</h5></a>
                    <p>02 Hours ago</p>
                </div>
            </div>
            <div class="media post_item">
                <img src="<?php echo DIST ?>img/blog/popular-post/post3.jpg" alt="post">
                <div class="media-body">
                    <a href="#"><h5>Astronomy Or Astrology</h5></a>
                    <p>03 Hours ago</p>
                </div>
            </div>
            <div class="media post_item">
                <img src="<?php echo DIST ?>img/blog/popular-post/post4.jpg" alt="post">
                <div class="media-body">
                    <a href="#"><h5>Asteroids telescope</h5></a>
                    <p>01 Hours ago</p>
                </div>
            </div>
            <div class="br"></div>
        </aside>
        <aside class="single_sidebar_widget post_category_widget">
            <h4 class="widget_title">Post Catgories</h4>
            <ul class="list cat-list">
                <?php if (isset($data['categories'])) {
                    foreach ($data['categories'] as $category) { ?>
                        <li>
                            <a href="<?php echo ROOT . 'blog/category/' . escape(str_replace(' ', '_', $category['p_category'])) ?>" class="d-flex justify-content-between">
                                <p><?php echo ucfirst(escape($category['p_category'])) ?></p>
                                <p><?php echo escape($category['COUNT(`p_category`)']) ?></p>
                            </a>
                        </li>
                    <?php }
                } ?>
            </ul>
            <div class="br"></div>
        </aside>
        <aside class="single-sidebar-widget newsletter_widget">
            <h4 class="widget_title">Newsletter</h4>
            <p>
                Here, I focus on a range of items and features that we use in life without
                giving them a second thought.
            </p>
            <div class="form-group d-flex flex-row">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Enter email"
                           onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email'">
                </div>
                <a href="#" class="bbtns">Subscribe</a>
            </div>
            <div class="br"></div>
        </aside>
        <aside class="single-sidebar-widget tag_cloud_widget">
            <h4 class="widget_title">Tag Clouds</h4>
            <ul class="list">
                <?php if (isset($data['tags'])) {
                    foreach ($data['tags'] as $tag) { ?>
                        <li><a href="<?php echo ROOT . 'blog/tag/' . escape(str_replace(' ', '_', $tag['pt_text'])) ?>"><?php echo ucfirst(escape($tag['pt_text'])) ?></a></li>
                    <?php }
                } ?>
            </ul>
        </aside>
    </div>
</div>
<!--Side Bar Area-->
