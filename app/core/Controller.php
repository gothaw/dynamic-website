<?php

class Controller {

    protected $view;
    protected $model;

    public function model($modelName){
        if(file_exists('../app/models/' . $modelName . '.php')){
            require_once '../app/models/' . $modelName . '.php';
            $this->model = new $modelName;
            return $this->model;
        }
    }

    public function view($viewName, $data=[]){
        if(file_exists('../app/views/' . $viewName . '.php')){
            $this->view = new View($viewName,$data);
        }
    }
}