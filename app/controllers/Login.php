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
        $footerTheme = 'dark';
        $bannerIndex = '2';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);

        $this->view($thisPage,$path, [
                'navPages' => $navPages,
                'pageDetails' => $pageDetails,
                'bannerIndex'=>$bannerIndex,
                'footerTheme' => $footerTheme]
        );
        $this->_view->renderView();
    }

    public function form(){
        trace($this);
        $this->_view->renderView();
    }
}