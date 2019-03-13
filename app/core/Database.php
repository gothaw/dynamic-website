<?php

class Database{

    private $host;
    private $user;
    private $password;
    private $database_name;
    private $connection_message;

    protected function connectToDatabase(){
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->database_name = "php-website";
        $mysqli = new mysqli($this->host, $this->user, $this->password, $this->database_name);
        return $mysqli;
    }

    public function returnFailMessage(){
        $mysqli = $this->connectToDatabase();
        if($mysqli->connect_error){
            return $this->connection_message="Something went wrong. It is our fault. Sorry. =(";
        }
    }
}