<?php

function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function trace($obj)
{
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

function startSessionOnce()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}