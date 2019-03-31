<?php

class Controller {

    protected $_view;
    protected $_model;
    protected $_navPages;
    protected $_pageDetails;
    protected $_path;

    public function __construct($page)
    {
        $this->_navPages = $this->model('NavBarPages')->getNavBarPages();
        $currentPage = $this->model('CurrentPage');
        $this->_pageDetails = $currentPage->getPageDetails($page);
        $this->_path = $currentPage->getPageUrl($page);
    }

    public function model($model){
        if(file_exists('../app/models/' . $model . '.php')){
            require_once '../app/models/' . $model . '.php';
            $this->_model = new $model;
            return $this->_model;
        }
        return null;
    }

    public function view($viewName, $view, $data=[]){
        if(file_exists('../app/views/' . $view . 'index.php')){
            $this->_view = new View($viewName,$view,$data);
        }
    }
}