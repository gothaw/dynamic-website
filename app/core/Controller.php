<?php

class Controller {

    protected $view;
    protected $model;

    public function model($model){
        if(file_exists('../app/models/' . $model . '.php')){
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }
    }

    public function view($viewName, $data=[]){
        $this->view = new View($viewName,$data);
        return $this->view;
        /*if(file_exists('../app/views/' . $viewName .'.php')){
            require_once '../app/views/' . $viewName .'.php';
        }*/
    }
}