<?php

class Schedule extends Controller {

    protected $_page;
    protected $_navPages;
    protected $_failMessage;

    public function __construct()
    {
        $this->_failMessage = $this->returnDatabaseMessage();
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
    }

    public function index(){
        $thisPage='schedule';
        $path='schedule';
        $footerTheme = 'light';
        $bannerIndex = '1';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);

        $this->view($thisPage,$path, [
            'navPages' => $navPages,
            'pageDetails' => $pageDetails,
            'bannerIndex'=>$bannerIndex,
            'footerTheme' => $footerTheme,
            'failMessage'=>$this->_failMessage]
        );
        $this->_view->renderView();
    }
}