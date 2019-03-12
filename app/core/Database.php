<?php

class Database{

    private $host;
    private $user;
    private $password;
    private $dbname;

    protected function connect(){
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->dbname = "td_db_2";
        $conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        return $conn;
    }
}