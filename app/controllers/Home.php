<?php

class Home extends Controller {

    private $_page;
    private $_navPages;
    private $_failMessage;
    private $_classes;
    private $_opinions;

    public function __construct()
    {
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
        $this->_classes = $this->model('Classes');
        $this->_opinions = $this->model('ClientOpinions');
    }

    public function index(){
        $thisPage='home';
        $path='index';
        $footerTheme = 'light';

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);
        $classes = $this->_classes->getClassesDetails(4);
        $opinions = $this->_opinions->getClientOpinions();

        $this->view($thisPage,$path, [
            'navPages' => $navPages,
            'pageDetails' => $pageDetails,
            'classes' => $classes ,
            'opinions' => $opinions,
            'footerTheme' => $footerTheme]
        );
        $this->_view->renderView();
    }

}