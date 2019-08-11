<?php

/**
 *                          Class Token
 * @desc                    Used to protect against CSRF attack. Includes static methods to generate sha1 token and check the token that has been submitted with a form.
 */
class Token
{
    /**
     * @method              generate
     * @desc                Method generates a token using uniqid() that then gets encrypted using sha1() function.
     *                      It uses Config's static method get to get token_name from config.php file.
     *                      The token is then added to the session as token => token_hash e.g. token => 23e2a...
     * @return              string {token_hash}
     */
    public static function generate(){
        $tokenName = Config::get('session/token_name');
        return Session::add($tokenName,sha1(uniqid()));
    }

    /**
     * @method              check
     * @param               $token {sha1 hash generated using generate method}
     * @desc                Method checks if token stored in the session is the same as token passed through in parameter.
     *                      Method used to protected against CSRF protection. It the token is the same it's removed from the session and method returns true.
     *                      Otherwise it returns false.
     * @return              bool
     */
    public static function check($token) {
        $tokenName = Config::get('session/token_name');
        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}