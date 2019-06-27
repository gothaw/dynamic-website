<!--================Blog Area =================-->
<section class="blog_area section-padding4">
    <div class="container">
        <div class="row">
            <?php
            switch ($subName)
            {
                case 'blog/post':
                    include("../app/views/blog/post.php");
                    break;
                default:
                    include("../app/views/blog/blog-posts.php");
            }
            include("../app/views/blog/side-bar.php");
            ?>
        </div>
    </div>
</section>
<!--================Blog Area =================-->