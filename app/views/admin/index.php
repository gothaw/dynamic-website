<?php

//CONTENT
switch ($subName){
    case 'membership':
        include("../app/views/admin/membership.php");
        break;
    default:
        include("../app/views/admin/admin-panel.php");
}
