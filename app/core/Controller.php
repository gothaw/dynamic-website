<?php

class Controller {

    protected $_view;
    protected $_model;

    public function model($model){
        if(file_exists('../app/models/' . $model . '.php')){
            require_once '../app/models/' . $model . '.php';
            $this->_model = new $model;
            return $this->_model;
        }
        return NULL;
    }

    public function view($viewName, $view, $data=[]){
        if(file_exists('../app/views/' . $view . '.php')){
            $this->_view = new View($viewName,$view,$data);
        }
    }
}