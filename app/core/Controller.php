<?php

class Controller {

    protected $view;
    protected $model;

    public function model($model_name){
        if(file_exists('../app/models/' . $model_name . '.php')){
            require_once '../app/models/' . $model_name . '.php';
            $this->model = new $model_name;
            return $this->model;
        }
    }

    public function view($view_name, $data=[]){
        if(file_exists('../app/views/' . $view_name . '.php')){
            $this->view = new View($view_name,$data);
        }
    }
}