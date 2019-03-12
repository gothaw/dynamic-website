<?php
    print_r($this);
    include ("includes/top.php");
    include ("includes/preloader.php");
    include ("includes/header.php");
    include ("includes/banner.php");

    echo 'Hello World. My Name is '. $this->view_data['name'].'</br>';
    echo 'This is another way to do it '. $this->getAction().'</br>';
    echo $this->getTitle().'</br>';

    //echo 'Hello World. My Name is '. $data['name'];


    echo ROOT .'</br>';

    if(array_key_exists('pages',$this->view_data)){
        print_r($this->view_data['pages']);
    }


    include ("includes/footer.php");