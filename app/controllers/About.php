<?php

class About extends Controller {

    protected $_page;
    protected $_navPages;
    protected $_classes;
    protected $_coaches;

    public function __construct()
    {
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
        $this->_classes = $this->model('Classes');
        $this->_coaches = $this->model('Coaches');
    }

    public function index(){
        $thisPage='about';
        $path='about';
        $footerTheme = 'dark';
        $bannerIndex = '2';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);
        $classes = $this->_classes->getClassesDetails();
        $coaches = $this->_coaches->getCoachesDetails();

        $this->view($thisPage,$path, [
            'navPages' => $navPages,
            'pageDetails' => $pageDetails,
            'classes' => $classes,
            'coaches' => $coaches ,
            'bannerIndex'=>$bannerIndex,
            'footerTheme' => $footerTheme]
        );
        $this->_view->renderView();
    }
}