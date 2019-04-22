<?php

//CONTENT
switch ($subName){
    case 'edit':
        include("../app/views/dashboard/update-form.php");
        break;
    default:
        include("../app/views/dashboard/dashboard.php");
}