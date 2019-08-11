<?php

/**
 *                          Class Session
 * @desc                    Class with static methods to manipulate values in $_SESSION. Allows for checking if exist, getting, adding and deleting values in session.
 */
class Session
{
    /**
     * @method              exists
     * @param               $name {string}
     * @desc                Checks if variable exists in $_SESSION super global and also if it is not empty.
     * @return              bool
     */
    public static function exists($name)
    {
        return (isset($_SESSION[$name]) && !empty($_SESSION[$name])) ? true : false;
    }

    /**
     * @method              add
     * @param               $name {string}
     * @param               $value {value to be stored in $_SESSION}
     * @desc                Adds $value to the $_SESSION under $name.
     * @return              string
     */
    public static function add($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    /**
     * @method              get
     * @param               $name {string}
     * @desc                Gets value of $name from $_SESSION super global.
     * @return              string
     */
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * @method              delete
     * @param               $name {string}
     * @desc                Deletes $name from $_SESSION super global.
     */
    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * @method              flash
     * @param               $name {string}
     * @param               $message {flash message as a string}
     * @desc                Method adds flash message ($message) to the $_SESSION under $name.
     *                      If flash message exists already, method returns the message and deletes it from the $_SESSION.
     * @return              string
     */
    public static function flash($name, $message = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::add($name, $message);
        }
    }
}