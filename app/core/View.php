<?php

class View {

    private $viewName;
    private $viewPath;
    private $viewData;

    public function __construct($viewName,$viewPath,$viewData)
    {
        $this->viewName = $viewName;
        $this->viewPath = $viewPath;
        $this->viewData = $viewData;
    }

    public function renderView(){
        require_once '../app/views/' . $this->viewPath . 'index.php';
    }

}