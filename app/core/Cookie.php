<?php

/**
 *                          Class Cookie
 * @desc                    Class with static methods to add and delete values in cookies.
 */
class Cookie
{
    /**
     * @method              exists
     * @param               $name {string}
     * @desc                Checks if $name key exits in the $_COOKIE super global.
     * @return              bool
     */
    public static function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * @method              add
     * @param               $name {string}
     * @param               $value {string}
     * @param               $expiry {int, in seconds added to current time()}
     * @desc                Methods adds $value in $_COOKIE super global and returns true if adding was successful.
     * @return              bool
     */
    public static function add($name, $value, $expiry)
    {
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    /**
     * @method              get
     * @param               $name {string}
     * @desc                Gets value of $name from $_COOKIE super global.
     * @return              string
     */
    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    /**
     * @method              delete
     * @param               $name {string}
     * @desc                Deletes $name from $_COOKIE super global.
     */
    public static function delete($name)
    {
        self::add($name, '', -1);
    }
}