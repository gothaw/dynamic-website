<?php

class Controller {

    protected $view;
    protected $model;

    public function model($model_class){
        if(file_exists('../app/models/' . $model_class . '.php')){
            require_once '../app/models/' . $model_class . '.php';
            $this->model = new $model_class;
            return $this->model;
        }
    }

    public function view($view_name,$view_file, $data=[]){
        if(file_exists('../app/views/' . $view_file . '.php')){
            $this->view = new View($view_name,$view_file,$data);
        }
    }

    /*public function view($view_name, $view_file, $data=[]){
        if(file_exists('../app/views/' . $view_file . '.php')){
            require_once '../app/views/' . $view_file . '.php';
        }
    }*/
}