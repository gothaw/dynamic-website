<?php

class Database{

    private $host;
    private $user;
    private $password;
    private $database_name;

    protected function connectToDatabase(){
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->database_name = "php-website";
        $mysqli = new mysqli($this->host, $this->user, $this->password, $this->database_name);
        return $mysqli;
    }
}