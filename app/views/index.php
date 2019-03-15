<?php
    //simplifying variables
    $data=$this->viewData;
    $name=$this->viewName;

    //trace($this);
    //trace($data);
    //trace(!isset($data['failMessage']));

    //HEAD
    include ("includes/top.php");
    //HEADER AND PRELOADER
    include ("includes/preloader.php");
    include ("includes/header.php");
    //CONTENT
    include ("includes/home/banner.php");
    if(isset($data['failMessage'])){
        include ("includes/fail-message.php");
    }
    else{
        include ("includes/home/home-about.php");
        include ("includes/home/featured.php");
        include ("includes/home/services.php");
        include ("includes/home/discount.php");
        include ("includes/home/client-opinions.php");
        include ("includes/home/join.php");
    }
    //FOOTER
    include ("includes/footer.php");