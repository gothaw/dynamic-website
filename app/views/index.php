<?php
    include ("includes/top.php");
    include ("includes/preloader.php");
    include ("includes/header.php");
    include ("includes/banner.php");

    echo 'Hello World. My Name is '. $this->view_data['name'].' ';
    echo $this->getTitle();

    //echo 'Hello World. My Name is '. $data['name'];

    echo ROOT;

    print_r($this);

    include ("includes/footer.php");