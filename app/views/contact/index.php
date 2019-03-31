<?php
//simplifying variables
$data=$this->viewData;
$name=$this->viewName;

//trace($this);
//trace($data);
//trace($name);
//trace($data['name']);

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

}
//FOOTER
include ("includes/footer.php");