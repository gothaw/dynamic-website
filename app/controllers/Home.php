<?php

class Home extends Controller{

    protected $_page;
    protected $_navPages;
    protected $_failMessage;
    protected $_classes;

    public function __construct()
    {
        $this->_failMessage = $this->returnDatabaseMessage();
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
        $this->_classes = $this->model('FeaturedClasses');
    }

    public function index(){
        $thisPage='home';
        $path='index';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);
        $classes = $this->_classes->getFeaturedClasses();


        $this->view($thisPage,$path, ['navPages' => $navPages, 'pageDetails' => $pageDetails, 'classes' => $classes , 'failMessage'=>$this->_failMessage]);
        $this->_view->renderView();
    }

}