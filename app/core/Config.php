<?php

class Config
{
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