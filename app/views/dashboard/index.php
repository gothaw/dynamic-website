<?php

//CONTENT
switch ($subName){
    case 'edit':
        include("../app/views/_includes/view-error.php");
        include("../app/views/dashboard/update-form.php");
        break;
    case 'changePass':
        include("../app/views/_includes/view-error.php");
        include("../app/views/dashboard/change-password.php");
        break;
    default:
        include("../app/views/dashboard/dashboard.php");
}