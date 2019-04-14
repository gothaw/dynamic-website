<?php

class Config
{
    /**
     * @method                  get
     * @param                   $path {path as a string to the relevant variable in $GLOBALS, for example, mysql/host or session/token_name}
     * @desc                    Method gets the value of a constant in $GLOBALS in config.php. It explodes the path by '/' and loops through the $GLOBALS associative array.
     * @return                  bool|mixed
     */
    public static function get($path = null)
    {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            foreach ($path as $value) {
                //loops through ['config'] array and finds which key is set
                if (isset($config[$value])) {
                    $config = $config[$value];
                }
            }
            return $config;
        }
        return false;
    }
}