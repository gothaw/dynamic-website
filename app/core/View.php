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
    protected $view_name;

    public function __construct($view_file,$view_data)
    {
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    public function renderView(){
        require_once '../app/views/' . $this->view_file . '.php';
    }

    public function getViewName(){
        return $this->view_name;
    }

    public function setViewName($view_name){
        $this->view_name=$view_name;
    }
}