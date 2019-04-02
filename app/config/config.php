<?php

//=========== DEFINING CONSTANTS AND GLOBAL VARIABLES ===========

define("ROOT", "http://localhost/php/dynamic-website/public/");
define("DIST", ROOT . "dist/");

$GLOBALS['config'] = [
    'mysql' => [
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db_name' => 'php-website'
    ],
    'remember' => [
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ],
    'session' => [
        'session_name' => 'user',
        'token_name' => 'token'
    ]
];

//=================  ERROR HANDLING (DEVELOPMENT) ===============

ini_set('display_errors', 'on');
error_reporting(E_ALL);

//=================  ERROR HANDLING (PRODUCTION) =================

/*ini_set('display_errors','off');
error_reporting(0);*/

//===========================  SESSION ===========================

startSessionOnce();