<?php
$data=$this->viewData;
$name=$this->viewName;

//trace($data);

//HEAD
include ("includes/top.php");
//HEADER AND PRELOADER
include ("includes/preloader.php");
include ("includes/header.php");
//CONTENT
include ("includes/banner.php");
if(isset($data['failMessage'])){
    include ("includes/fail-message.php");
}
else{
    echo "<p>form goes here</p>";
}

//FOOTER
include ("includes/footer.php");