<?php

class DbCheck extends Database {

    private $message;

    public function returnFailMessage(){
        $mysqli = $this->connectToDatabase();
        if($mysqli->connect_error){
            return $this->message="Something went wrong. It is our fault. Sorry. =(";
        }
    }

}