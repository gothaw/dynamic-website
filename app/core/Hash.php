<?php

class Hash
{
    public static function generateHash($string,$salt = ''){
        return hash('sha256',$string . $salt);
    }

    public static function generateSalt($length){
        return bin2hex(random_bytes($length));
    }

    //used in session, remember me
    public static function generateFromUniqueId(){
        return self::make(uniqid());
    }

}