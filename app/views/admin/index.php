<?php

//CONTENT
include("../app/views/_includes/view-error.php");
switch ($subName){
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
    default:
        include("../app/views/admin/admin-panel.php");
}