<?php
//CONTENT
//trace($data);
switch ($subName){
    case 'membership':
        include("../app/views/admin/user-search.php");
        break;
    case 'editMembership':
        include("../app/views/_includes/view-error.php");
        include("../app/views/admin/edit-membership.php");
        break;
    case 'members':
        include("../app/views/admin/user-search.php");
        break;
    case 'editUser':
        include("../app/views/_includes/view-error.php");
        include("../app/views/admin/edit-user.php");
        break;
    default:
        include("../app/views/admin/admin-panel.php");
}
