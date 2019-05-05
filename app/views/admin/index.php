<?php

//CONTENT
switch ($subName){
    case 'membership':
        include("../app/views/admin/membership.php");
        break;
    case 'editMembership':
        include("../app/views/_includes/view-error.php");
        include("../app/views/admin/edit-membership.php");
        break;
    case 'cancelMembership':
        include("../app/views/admin/cancel-membership.php");
        break;
    default:
        include("../app/views/admin/admin-panel.php");
}
