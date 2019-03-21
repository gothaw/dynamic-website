<?php

class Login extends Controller{

    protected $_page;
    protected $_navPages;
    protected $_failMessage;

    public function __construct() {
        $this->_failMessage = $this->returnDatabaseMessage();
        $this->_navPages = $this->model('NavBarPages');
    }

    public function index(){
        $thisPage='login';
        $path='login';
        $footerTheme = 'dark';
        $bannerIndex = '2';

        $navPages = $this->_navPages->getNavBarPages();

        $this->view($thisPage,$path, [
                'navPages' => $navPages,
                'bannerIndex'=>$bannerIndex,
                'footerTheme' => $footerTheme,
                'failMessage'=>$this->_failMessage]
        );
        $this->_view->renderView();
    }
}