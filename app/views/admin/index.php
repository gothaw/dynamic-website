<?php

//CONTENT
include("../app/views/_includes/view-error.php");
switch ($subName) {
    case 'admin-membership':
        include("../app/views/admin/user-search.php");
        break;
    case 'admin-membership/edit':
        include("../app/views/admin/edit-membership.php");
        break;
    case 'admin-membership/cancel':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-members':
        include("../app/views/admin/user-search.php");
        break;
    case 'admin-members/edit':
        include("../app/views/admin/edit-user.php");
        break;
    case 'admin-members/add':
        include("../app/views/admin/add-user.php");
        break;
    case 'admin-members/delete':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-classes':
        include("../app/views/admin/admin-classes.php");
        break;
    case 'admin-classes/edit':
        include("../app/views/admin/edit-class.php");
        break;
    case 'admin-classes/add':
        include("../app/views/admin/add-class.php");
        break;
    case 'admin-classes/delete':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-coaches':
        include("../app/views/admin/admin-coaches.php");
        break;
    case 'admin-coaches/edit':
        include("../app/views/admin/edit-coach.php");
        break;
    case 'admin-coaches/add':
        include("../app/views/admin/add-coach.php");
        break;
    case 'admin-coaches/delete':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-schedule':
        include("../app/views/admin/admin-schedule.php");
        break;
    case 'admin-schedule/edit':
        include("../app/views/admin/edit-scheduled-class.php");
        break;
    case 'admin-schedule/add':
        include("../app/views/admin/add-scheduled-class.php");
        break;
    case 'admin-schedule/delete':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-schedule/users':
        include("../app/views/admin/users-schedule.php");
        break;
    case 'admin-schedule/users-delete':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-blog':
        include("../app/views/admin/admin-blog.php");
        break;
    case 'admin-blog/edit':
        include("../app/views/admin/edit-post.php");
        break;
    case 'admin-blog/add':
        include("../app/views/admin/add-post.php");
        break;
    case 'admin-blog/delete':
        include("../app/views/admin/delete-item.php");
        break;
    case 'admin-blog/comments':
        include("../app/views/admin/blog-comments.php");
        break;
    case 'admin-blog/comments-edit':
        include("../app/views/admin/edit-comment.php");
        break;
    case 'admin-blog/comments-delete':
        include("../app/views/admin/delete-item.php");
        break;
    default:
        include("../app/views/admin/admin-panel.php");
}