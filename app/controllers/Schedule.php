<?php

class Schedule extends Controller {

    protected $_page;
    protected $_navPages;

    public function __construct()
    {
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
    }

    public function index(){
        $thisPage='schedule';
        $path='schedule';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);

        $this->view($thisPage,$path, [
            'navPages' => $navPages,
            'pageDetails' => $pageDetails
        ]);
        $this->_view->setFooterTheme('light');
        $this->_view->setBannerImg('light');
        $this->_view->renderView();
    }
}