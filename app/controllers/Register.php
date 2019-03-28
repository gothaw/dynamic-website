<?php

class Register extends Controller {

    protected $_page;
    protected $_navPages;

    public function __construct() {
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
    }

    public function index(){
        $thisPage='register';
        $path='register';
        $footerTheme = 'dark';
        $bannerIndex = '1';

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
}