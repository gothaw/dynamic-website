<?php

class Controller {

    protected $view;
    protected $model;

    public function model($model){
        if(file_exists('../app/models/' . $model . '.php')){
            require_once '../app/models/' . $model . '.php';
            $this->model = new $model;
            return $this->model;
        }
    }

    public function view($viewName,$view, $data=[]){
        if(file_exists('../app/views/' . $view . '.php')){
            $this->view = new View($viewName,$view,$data);
        }
    }

    public function returnDatabaseMessage(){
        if(file_exists('../app/core/DatabaseCheck.php')){
            require_once '../app/core/DatabaseCheck.php';
            $database_check = new DatabaseCheck();
            return $database_check->checkDatabaseConnection();
        }
    }
}