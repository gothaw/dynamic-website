<!--================Blog Area =================-->
<?php include("./app/views/_includes/view-error.php"); ?>
<section class="blog_area section-padding4">
    <div class="container">
        <div class="row">
            <?php
            switch ($subName) {
                case 'blog/post':
                    include("./app/views/blog/single-post.php");
                    break;
                default:
                    include("./app/views/blog/blog-posts.php");
            }
            include("./app/views/blog/side-bar.php");
            ?>
        </div>
    </div>
</section>
<!--================Blog Area =================-->