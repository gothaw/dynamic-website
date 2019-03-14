<?php
    $data=$this->view_data;

    trace($this);
    $data=$this->view_data;
    trace($data);
    trace($data['name']);

    include ("includes/top.php");
    include ("includes/preloader.php");
    include ("includes/header.php");
    include ("includes/home/banner.php");
    include ("includes/home/home-about.php");
    include ("includes/home/featured.php");

    echo 'Hello World. My Name is '. $data['name'].'</br>';

    echo ROOT .'</br>';

    if(array_key_exists('pages',$this->view_data)){
        print_r($this->view_data['pages']);
    }


    include ("includes/footer.php");