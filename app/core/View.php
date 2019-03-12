<?php
/**
 * Created by PhpStorm.
 * User: Radosław
 * Date: 11.03.2019
 * Time: 20:38
 */

class View
{
    protected $view_file;
    protected $view_data;
    protected $view_title;

    public function __construct($view_file,$view_data)
    {
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    public function render(){
        if(file_exists('../app/views/' . $this->view_file . '.php')){
            require_once '../app/views/' . $this->view_file . '.php';
        }
    }

    public function getTitle(){
        return $this->view_title;
    }

    public function setTitle($view_title){
        $this->view_title=$view_title;
    }


    public function getAction(){
        return $this->view_data['name'];
    }
}