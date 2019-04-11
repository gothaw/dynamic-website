<?php

class Redirect
{
    /**
     * @method              to
     * @param               $location {if name of a controller as a string, if int - name of the error}
     * @desc                Method uses header function to redirect to $location. If $location is numeric than it redirects to specific error.
     */
    public static function to($location = null){
        if($location){
            if(is_numeric($location)){
                switch ($location){
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include_once ('../app/views/_errors/not-found-error.php');
                        exit();
                    break;
                    case 500:
                        header('HTTP/1.1 500 Internal Server Error');
                        include_once ('../app/views/_errors/db-error.php');
                        exit();
                    break;
                }
            }
            header('Location: ' . ROOT . $location);
            exit();
        }
    }
}