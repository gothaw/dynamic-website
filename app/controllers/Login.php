<?php

class Login extends Controller {

    protected $_page;
    protected $_navPages;

    public function __construct() {
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
    }

    public function index(){
        $thisPage='login';
        $path='login';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);

        $this->view($thisPage,$path, [
                'navPages' => $navPages,
                'pageDetails' => $pageDetails
        ]);
        $this->_view->setFooterTheme('dark');
        $this->_view->setBannerImg('dark');
        $this->_view->renderView();
    }

    public function form(){
        trace($this);
        print_r($_SESSION);
//        $this->_view->renderView();
    }
}