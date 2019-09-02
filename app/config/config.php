<?php

/**
 *                  Configuration and Constants
 */

//=========== DEFINING CONSTANTS AND GLOBAL VARIABLES ===========

define("ROOT", "http://localhost/php/dynamic-website/");
define("DIST_RELATIVE_PATH", "public/dist/");
define("DIST", ROOT . DIST_RELATIVE_PATH);
define("EMAIL_TO", "email@mail.com");

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
    ],
    'recaptcha' => [
        'site_key' => 'reCAPTCHA_site_key',
        'private_key' => 'reCAPTCHA_private_key'
    ]
];

//======================  TIME ZONE CONFIG ======================

date_default_timezone_set('Europe/London');

//=================  ERROR HANDLING (DEVELOPMENT) ===============

ini_set('display_errors', 'on');
error_reporting(E_ALL);

//=================  ERROR HANDLING (PRODUCTION) =================

/*ini_set('display_errors','off');
error_reporting(0);*/

//===========================  SESSION ===========================

startSessionOnce();