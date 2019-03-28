<?php

class Database{

    private static $_instance = null;

    private $_host;
    private $_user;
    private $_password;
    private $_databaseName;

    private $_pdo;
    private $_error = false;
    private $_query;
    private $_result;
    private $_rowCount;

    private function __construct(){
        try{
            $this->_host = "localhost";
            $this->_user = "root";
            $this->_password = "";
            $this->_databaseName = "php-website";
            $this->_pdo = new PDO("mysql:host=" . $this->_host . ";dbname=" . $this->_databaseName,$this->_user,$this->_password);
        } catch (PDOException $e){
            exit("Something went wrong. It is our fault. Sorry. = (");
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)){
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql, $parameters = []){
        // Resetting error to false after previous query
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            if(count($parameters)){
                $i = 1;
                foreach ($parameters as $parameter){
                    $this->_query->bindValue($i,$parameter);
                    $i++;
                }
            }
            if($this->_query->execute()){
                $this->_result = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                $this->_rowCount = $this->_query->rowCount();
            }
            else{
                $this->_error = true;
            }
        }
        return $this;
    }

    public function getResult(){
        if($this->_rowCount === 1){
            return $this->_result[0];
        }
        else{
            return $this->_result;
        }
    }

}