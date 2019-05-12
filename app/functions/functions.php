<?php

/**
 * @function        escape
 * @param           $string
 * @desc            Function escapes a string using htmlentities() function.
 * @return          string
 */
function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/**
 * @function        trace
 * @param           $obj
 * @desc            *** DEVELOPMENT ONLY *** Function using print_r wrapped in pre tags to trace an object.
 */
function trace($obj)
{
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

/**
 * @function        startSessionOnce
 * @desc            Function starts session is it has not been started.
 */
function startSessionOnce()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

/**
 * @function        toSnakeCase
 * @param           $string
 * @desc            Converts PascalCase or camelCase string to lisp-case.
 * @return          string
 */
function toLispCase($string)
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $string));
}
