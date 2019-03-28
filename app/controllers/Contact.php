<?php

class Contact extends Controller {

    protected $_page;
    protected $_navPages;
    protected $_user;

    public function __construct()
    {
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
        $this->_user = $this->model('User');
    }

    public function index($name = ''){
        $thisPage='contact';
        $path='contact';
        $footerTheme = 'dark';
        $bannerIndex = '2';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);
        $this->_user->name = $name;

        $this->view($thisPage,$path, [
            'name'=>$name,
            'navPages' => $navPages,
            'pageDetails' => $pageDetails,
            'bannerIndex'=>$bannerIndex,
            'footerTheme' => $footerTheme]
        );
        $this->_view->renderView();
    }
}