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
    case 'admin-members':
        include("../app/views/admin/user-search.php");
        break;
    case 'admin-members/edit':
        include("../app/views/admin/edit-user.php");
        break;
    case 'admin-members/add':
        include("../app/views/admin/add-user.php");
        break;
    default:
        include("../app/views/admin/admin-panel.php");
}