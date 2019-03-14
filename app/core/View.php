<?php

class View
{
    protected $view_name;
    protected $view_file;
    protected $view_data;

    public function __construct($view_name,$view_file,$view_data)
    {
        $this->view_name = $view_name;
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    public function renderView(){
        require_once '../app/views/' . $this->view_file . '.php';
    }
}