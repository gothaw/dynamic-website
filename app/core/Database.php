<?php

class Database{

    private $_host;
    private $_user;
    private $_password;
    private $_databaseName;

    protected function connectToDatabase(){
        $this->_host = "localhost";
        $this->_user = "root";
        $this->_password = "";
        $this->_databaseName = "php-website";
        $mysqli = new mysqli($this->_host, $this->_user, $this->_password, $this->_databaseName);
        return $mysqli;
    }
}