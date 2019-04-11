<?php

class Hash
{
    /**
     * @method          generateHash
     * @param           $string
     * @param           $salt {salt assumed as a default as an empty string}
     * @desc            Concatenates $string an salt and generates a hash using sha256.
     * @return          string
     */
    public static function generateHash($string,$salt = ''){
        return hash('sha256',$string . $salt);
    }

    /**
     * @method          generateSalt
     * @param           $length {length as an int}
     * @return          string
     * @desc            Generates salt by using random_bytes function with $length as parameter and converting it then hexadecimal using bin2hex.
     * @throws          Exception
     */
    public static function generateSalt($length){
        return bin2hex(random_bytes($length));
    }

    /**
     * @method          generateFromUniqueId
     * @desc            Generates hash from uniqid() by invoking generateHash method.
     * @return          string
     */
    public static function generateFromUniqueId(){
        return self::generateHash(uniqid());
    }

}