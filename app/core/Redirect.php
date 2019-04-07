<?php

class Redirect
{
    public static function to($location = null){
        if($location){
            header('Location: ' . ROOT . $location);
            exit();
        }
    }
}