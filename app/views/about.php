<?php
//simplifying variables
$data=$this->viewData;
$name=$this->viewName;

//HEAD
include ("includes/top.php");
//HEADER AND PRELOADER
include ("includes/preloader.php");
include ("includes/header.php");
//CONTENT
if(isset($data['failMessage'])){
    include ("includes/fail-message.php");
}
else{
    include ("includes/banner.php");
    include ("includes/about/about-section.php");
    include ("includes/classes.php");
    include ("includes/about/coaches.php");
}
//FOOTER
include ("includes/footer.php");