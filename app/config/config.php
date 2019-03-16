<?php
    define("ROOT", "http://localhost/php/dynamic-website/public/");
    define("DIST", ROOT. "/dist/");

    //===========  ERROR HANDLING (DEVELOPMENT):
    ini_set('display_errors','on');
    error_reporting(E_ALL);

    function trace($obj){
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }


//===========  ERROR HANDLING (PRODUCTION):
    /*ini_set('display_errors','off');
    error_reporting(0);*/