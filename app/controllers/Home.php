<?php

class Home extends Controller{

    protected $_page;
    protected $_navPages;
    protected $_failMessage;
    protected $_classes;
    protected $_opinions;

    public function __construct()
    {
        $this->_failMessage = $this->returnDatabaseMessage();
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
            'footerTheme' => $footerTheme,
            'failMessage'=>$this->_failMessage]
        );
        $this->_view->renderView();
    }

}