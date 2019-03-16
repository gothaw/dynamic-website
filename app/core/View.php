<?php

class View
{
    public $viewName;
    public $viewFile;
    public $viewData;

    public function __construct($viewName,$viewFile,$viewData)
    {
        $this->viewName = $viewName;
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;
    }

    public function renderView(){
        require_once '../app/views/' . $this->viewFile . '.php';
    }
}