<?php

class Database{

    private $host;
    private $user;
    private $password;
    private $databaseName;

    protected function connectToDatabase(){
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->databaseName = "php-website";
        $mysqli = new mysqli($this->host, $this->user, $this->password, $this->databaseName);
        return $mysqli;
    }
}