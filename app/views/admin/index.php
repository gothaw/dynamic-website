<?php

// Views in admin panel controlled by secondary view name ($subName)
include("./app/views/_includes/view-error.php");
switch ($subName) {
    case 'admin-membership':
        include("./app/views/admin/_includes/user-search.php");
        break;
    case 'admin-membership/edit':
        include("./app/views/admin/membership/edit-membership.php");
        break;
    case 'admin-membership/cancel':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-members':
        include("./app/views/admin/_includes/user-search.php");
        break;
    case 'admin-members/edit':
        include("./app/views/admin/members/edit-user.php");
        break;
    case 'admin-members/add':
        include("./app/views/admin/members/add-user.php");
        break;
    case 'admin-members/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-classes':
        include("./app/views/admin/classes/admin-classes.php");
        break;
    case 'admin-classes/edit':
        include("./app/views/admin/classes/edit-class.php");
        break;
    case 'admin-classes/add':
        include("./app/views/admin/classes/add-class.php");
        break;
    case 'admin-classes/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-coaches':
        include("./app/views/admin/coaches/admin-coaches.php");
        break;
    case 'admin-coaches/edit':
        include("./app/views/admin/coaches/edit-coach.php");
        break;
    case 'admin-coaches/add':
        include("./app/views/admin/coaches/add-coach.php");
        break;
    case 'admin-coaches/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-schedule':
        include("./app/views/admin/schedule/admin-schedule.php");
        break;
    case 'admin-schedule/edit':
        include("./app/views/admin/schedule/edit-scheduled-class.php");
        break;
    case 'admin-schedule/add':
        include("./app/views/admin/schedule/add-scheduled-class.php");
        break;
    case 'admin-schedule/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-schedule/users':
        include("./app/views/admin/schedule/users-schedule.php");
        break;
    case 'admin-schedule/users-delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-blog':
        include("./app/views/admin/blog_posts/admin-blog.php");
        break;
    case 'admin-blog/edit':
        include("./app/views/admin/blog_posts/edit-post.php");
        break;
    case 'admin-blog/add':
        include("./app/views/admin/blog_posts/add-post.php");
        break;
    case 'admin-blog/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-blog/comments':
        include("./app/views/admin/blog_posts/blog-comments.php");
        break;
    case 'admin-blog/comments-edit':
        include("./app/views/admin/blog_posts/edit-comment.php");
        break;
    case 'admin-blog/comments-delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-comments':
        include("./app/views/admin/comments/admin-comments.php");
        break;
    case 'admin-comments/approve':
        include("./app/views/admin/comments/approve-comment.php");
        break;
    case 'admin-comments/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    case 'admin-blog-images':
        include("./app/views/admin/blog_images/admin-blog-images.php");
        break;
    case 'admin-blog-images/add':
        include("./app/views/admin/blog_images/admin-blog-images-add.php");
        break;
    case 'admin-blog-images/delete':
        include("./app/views/admin/_includes/delete-item.php");
        break;
    default:
        include("./app/views/admin/_includes/admin-panel.php");
}