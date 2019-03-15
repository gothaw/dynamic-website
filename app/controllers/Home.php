<?php

class Home extends Controller{

    protected $page;
    protected $navPages;
    protected $failMessage;

    public function __construct()
    {
        $this->failMessage = $this->returnDatabaseMessage();
        $this->navPages = $this->model('NavBarPages');
        $this->page = $this->model('CurrentPage');
    }

    public function index(){
        $thisPage='home';
        $path='index';

        $navPages = $this->navPages->getNavBarPages();
        $pageDetails = $this->page->getPageDetails($thisPage);

        $this->view($thisPage,$path, ['navPages' => $navPages, 'pageDetails' => $pageDetails, 'failMessage'=>$this->failMessage]);
        $this->view->renderView();
    }

}