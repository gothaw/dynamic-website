<?php

class DatabaseCheck extends Database {

    private $_message;

    public function checkDatabaseConnection(){
        $mysqli = $this->connectToDatabase();
        if($mysqli->connect_error){
            return $this->_message="Something went wrong. It is our fault. Sorry. =(";
        }
    }

}