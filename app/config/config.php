<?php

define("ROOT", "http://localhost/php/dynamic-website/public/");
define("DIST", ROOT. "/dist/");

//===========  ERROR HANDLING (DEVELOPMENT) ==========
ini_set('display_errors','on');
error_reporting(E_ALL);
//===========  ERROR HANDLING (PRODUCTION) ===========
/*ini_set('display_errors','off');
error_reporting(0);*/
//=====================  SESSION =====================
function startSessionOnce(){
    if(!isset($_SESSION)){
        session_start();
    }
}
startSessionOnce();
