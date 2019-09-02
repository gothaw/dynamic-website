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
            <h4 class="widget_title">Popular Posts</h4>
            <?php if(isset($data['popularPosts'])){
                foreach ($data['popularPosts'] as $post){ ?>
                    <div class="post_item">
                        <img src="<?php echo DIST . escape($post['p_thumb_url']) ?>" alt="<?php echo escape($post['p_img_alt']) ?>">
                        <div class="media-body">
                            <a href="<?php echo ROOT . 'blog/post/' . escape($post['p_id']) ?>"><h5 class="popular_post_title"><?php echo escape($post['p_title']) ?></h5></a>
                            <p><?php echo escape($post['p_date']) ?></p>
                        </div>
                    </div>
                <?php }
            }?>
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
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
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
