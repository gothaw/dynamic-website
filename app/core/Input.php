<?php

class Input
{
    /**
     * @method              exists
     * @param               $type {type of the HTTP method: 'post', 'get'}
     * @desc                Checks if $_POST, $_GET super globals exist i.e. are not empty.
     * @return              bool
     */
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * @method              get
     * @param               $item {key in the super global associative array}
     * @param               $type {type of the super global}
     * @desc                Returns the value of the $item in the super global.
     * @return              mixed|string
     */
    public static function getValue($item, $type = 'post')
    {
        if ($type = 'post' && isset($_POST[$item])) {
            return $_POST[$item];
        } else if ($type = 'get' && isset($_GET[$item])) {
            return $_GET[$item];
        }  else {
            return '';
        }
    }
}